<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Notifications\AlertNotification;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Requests\PostRequest;
use Illuminate\Auth\Access\AuthorizationException;

class DiscussionPostController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('verified');
        $this->authorizeResource(Post::class);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discussion $discussion, Post $post)
    {
        return view('forum::posts.edit', [
            'post' => $post,
            'current' => $post,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PostRequest $request, Discussion $discussion)
    {
        if ($discussion->is_locked && ! $request->user()->can('forum.discussions')) {
            throw new AuthorizationException();
        }

        $nextPostTime = Post::nextPostTime($request->user());

        if ($nextPostTime !== null) {
            return redirect()->back()->withInput()
                ->with('error', trans('forum::messages.posts.delay', ['time' => $nextPostTime]));
        }

        $post = $discussion->posts()->create([
            ...$request->validated(),
            'content_format' => setting('forum.editor', 'bbcode'),
        ]);

        $post->persistPendingAttachments($request->input('pending_id'));

        if (! $request->user()->is($discussion->author)) {
            (new AlertNotification(trans('forum::messages.notifications.reply', [
                'user' => $request->user()->name,
                'discussion' => $discussion->title,
            ])))
                ->link(route('forum.discussions.show', $discussion, false))
                ->from($request->user())
                ->send($discussion->author);
        }

        if (($webhookUrl = setting('forum.webhook')) !== null) {
            rescue(fn () => $post->createDiscordWebhook()->send($webhookUrl));
        }

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.posts.status.created'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostRequest $request, Discussion $discussion, Post $post)
    {
        $post->update($request->validated());

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.posts.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Discussion $discussion, Post $post)
    {
        $post->delete();

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.posts.status.deleted'));
    }
}
