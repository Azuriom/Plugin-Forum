<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Models\Tag;
use Azuriom\Plugin\Forum\Requests\DiscussionRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class ForumDiscussionController extends Controller
{
    public function __construct()
    {
        $this->middleware('verified');
        $this->authorizeResource(Discussion::class);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Forum $forum)
    {
        Gate::authorize('create', [Discussion::class, $forum]);

        return view('forum::discussions.create', [
            'forum' => $forum,
            'current' => $forum,
            'tags' => Tag::all()->filter(fn (Tag $tag) => $tag->userCanUse()),
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(DiscussionRequest $request, Forum $forum)
    {
        Gate::authorize('create', [Discussion::class, $forum]);

        $user = $request->user();
        $nextPostTime = Post::nextPostTime($user);

        if ($nextPostTime !== null) {
            return redirect()->back()->withInput()
                ->with('error', trans('forum::messages.posts.delay', ['time' => $nextPostTime]));
        }

        $attributes = $user->can('forum.discussions')
            ? ['title', 'is_pinned', 'is_locked'] : ['title'];

        /** @var \Azuriom\Plugin\Forum\Models\Discussion $discussion */
        $discussion = $forum->discussions()->create(Arr::only($request->validated(), $attributes));

        $post = $discussion->posts()->create([
            'content' => $request->input('content'),
            'content_format' => setting('forum.editor', 'bbcode'),
        ]);

        $post->persistPendingAttachments($request->input('pending_id'));

        if ($user->can('forum.discussions') || $user->can('forum.tags')) {
            $discussion->tags()->sync(array_keys($request->input('tags', [])));
        }

        if (! empty($forum->default_tags)) {
            $discussion->tags()->syncWithoutDetaching($forum->default_tags);
        }

        if ($request->filled('poll') && $user->can('forum.polls.create')) {
            $validated = Arr::only($request->validated(), [
                'question', 'multiple_choice', 'results_before_vote', 'remove_vote', 'closes_at',
            ]);

            $poll = $discussion->poll()->create($validated);

            foreach ($request->input('options') as $option) {
                $poll->options()->create(['value' => $option]);
            }
        }

        if (($webhookUrl = setting('forum.webhook')) !== null) {
            rescue(fn () => $post->createDiscordWebhook()->send($webhookUrl));
        }

        return to_route('forum.discussions.show', $discussion);
    }

    protected function resourceAbilityMap(): array
    {
        return Arr::except(parent::resourceAbilityMap(), ['create', 'store']);
    }
}
