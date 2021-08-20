<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\Tag;
use Azuriom\Plugin\Forum\Requests\DiscussionRequest;
use Illuminate\Support\Arr;

class DiscussionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->authorizeResource(Discussion::class);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function show(Discussion $discussion)
    {
        $discussion->load(['author.user', 'forum.category']);

        $posts = $discussion->posts()
            ->with([
                'likes.author' => function ($query) {
                    $query->without('role');
                }, 'author' => function ($query) {
                    $query->withCount(['likes', 'posts', 'discussions']);
                }
            ])->oldest()->paginate();

        $discussion->setRelation('posts', $posts);

        return view('forum::discussions.show', [
            'discussion' => $discussion,
            'current' => $discussion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function edit(Discussion $discussion)
    {
        $post = $discussion->posts()->first();

        return view('forum::discussions.edit', [
            'discussion' => $discussion,
            'discussionContent' => $post->content ?? null,
            'editor' => $post->content_format ?? null,
            'current' => $discussion,
            'forums' => Forum::all(),
            'tags' => Tag::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\DiscussionRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     */
    public function update(DiscussionRequest $request, Discussion $discussion)
    {
        if ($request->user()->can('forum.discussions')) {
            $discussion->forceFill(Arr::except($request->validated(), 'content'))->save();

            $discussion->tags()->sync(array_keys($request->input('tags', [])));
        } else {
            $discussion->update(Arr::except($request->validated(), ['is_pinned', 'is_locked', 'forum_id']));
        }

        $post = $discussion->posts()->oldest()->first();

        $post->update(['content' => $request->input('content')]);

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.discussions.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return \Illuminate\Http\Response
     *
     * @throws \Exception
     */
    public function destroy(Discussion $discussion)
    {
        $discussion->posts()->delete();

        $discussion->delete();

        ActionLog::log('forum-discussions.deleted', $discussion);

        return redirect()->route('forum.home')
            ->with('success', trans('forum::messages.discussions.status.deleted'));
    }
}
