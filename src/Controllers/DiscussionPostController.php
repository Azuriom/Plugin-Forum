<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Notifications\AlertNotification;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Requests\PostRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;

class DiscussionPostController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');

        $this->authorizeResource(Post::class);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return \Illuminate\Http\Response
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
     * @param  \Azuriom\Plugin\Forum\Requests\PostRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(PostRequest $request, Discussion $discussion)
    {
        if ($discussion->is_locked && ! $request->user()->isAdmin()) {
            throw new AuthorizationException();
        }

        $nextPostTime = Post::nextPostTime($request->user());

        if ($nextPostTime !== null) {
            return redirect()->back()->withInput()
                ->with('error', trans('forum::messages.posts.delay', ['time' => $nextPostTime]));
        }

        $discussion->posts()->create($request->validated());

        if (! $request->user()->is($discussion->author)) {
            $notification = (new AlertNotification(trans('forum::messages.notifications.reply', [
                'user' => $request->user()->name,
                'discussion' => $discussion->title,
            ])))->from($request->user());

            $discussion->author->notifications()->create($notification->toArray());
        }

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.posts.status.created'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\PostRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Discussion $discussion, Post $post)
    {
        $post->update($request->validated());

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.posts.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Request $request, Discussion $discussion, Post $post)
    {
        $post->delete();

        ActionLog::log('forum-post.deleted', $post);

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.posts.status.deleted'));
    }
}
