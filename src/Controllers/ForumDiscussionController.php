<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Models\Tag;
use Azuriom\Plugin\Forum\Requests\DiscussionRequest;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class ForumDiscussionController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Discussion::class);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function create(Forum $forum)
    {
        return view('forum::discussions.create', [
            'forum' => $forum,
            'current' => $forum,
            'tags' => Tag::all(),
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Azuriom\Plugin\Forum\Requests\DiscussionRequest  $request
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(DiscussionRequest $request, Forum $forum)
    {
        if ($forum->is_locked && ! $request->user()->isAdmin()) {
            throw new AuthorizationException();
        }

        $nextPostTime = Post::nextPostTime($request->user());

        if ($nextPostTime !== null) {
            return redirect()->back()->withInput()
                ->with('error', trans('forum::messages.posts.delay', ['time' => $nextPostTime]));
        }

        /** @var \Azuriom\Plugin\Forum\Models\Discussion $discussion */
        $discussion = $forum->discussions()->create(Arr::except($request->validated(), ['is_pinned', 'is_locked']));

        $post = $discussion->posts()->create([
            'content' => $request->input('content'),
            'content_format' => setting('forum.editor', 'bbcode'),
        ]);

        $post->persistPendingAttachments($request->input('pending_id'));

        if ($request->user()->can('forum.discussions')) {
            $discussion->forceFill(Arr::except($request->validated(), 'content'))->save();

            $discussion->tags()->sync(array_keys($request->input('tags', [])));
        }

        if (! empty($forum->default_tags)) {
            $discussion->tags()->attach($forum->default_tags);
        }

        if (($webhookUrl = setting('forum.webhook')) !== null) {
            rescue(fn () => $post->createDiscordWebhook()->send($webhookUrl));
        }

        return redirect()->route('forum.discussions.show', $discussion);
    }
}
