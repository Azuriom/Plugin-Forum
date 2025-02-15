<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Tag;
use Azuriom\Plugin\Forum\Requests\DiscussionRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class DiscussionController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('verified')->except('show');
        $this->authorizeResource(Discussion::class);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Discussion $discussion)
    {
        $discussion->load([
            'author' => fn (Builder $query) => $query->without('role'),
            'forum.category',
            'tags',
        ]);

        $posts = $discussion->posts()
            ->with([
                'likes.author' => fn (Builder $query) => $query->without('role'),
                'author' => fn ($query) => $query->with('user')->withCount([
                    'likes', 'posts', 'discussions',
                ]),
            ])
            ->oldest()
            ->paginate();

        $discussion->setRelation('posts', $posts);

        $key = 'forum.discussions.views.'.$discussion->id;
        $views = Cache::get($key, []);

        if (! in_array($request->ip(), $views, true)) {
            $discussion->increment('views');
            Cache::put($key, [...$views, $request->ip()], now()->endOfDay());
        }

        return view('forum::discussions.show', [
            'discussion' => $discussion,
            'current' => $discussion,
            'pendingId' => old('pending_id', Str::uuid()),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discussion $discussion)
    {
        $post = $discussion->posts()->first();

        return view('forum::discussions.edit', [
            'firstPost' => $post,
            'discussion' => $discussion,
            'discussionContent' => $post->content ?? null,
            'editor' => $post->content_format ?? null,
            'current' => $discussion,
            'categories' => Category::with('forums')->get(),
            'tags' => Tag::all()->filter(fn (Tag $tag) => $tag->userCanUse()),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscussionRequest $request, Discussion $discussion)
    {
        $user = $request->user();

        if ($user->can('forum.discussions')) {
            $discussion->forceFill(Arr::except($request->validated(), 'content'))->save();
        } else {
            $discussion->update(Arr::except($request->validated(), ['is_pinned', 'is_locked', 'forum_id']));
        }

        if ($user->can('forum.discussions') || $user->can('forum.tags')) {
            $discussion->tags()->sync(array_keys($request->input('tags', [])));
        }

        $post = $discussion->posts()->oldest()->first();

        $post->update(['content' => $request->input('content')]);

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.discussions.status.updated'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Discussion $discussion)
    {
        $discussion->delete();

        ActionLog::log('forum-discussions.deleted', $discussion);

        return to_route('forum.home')
            ->with('success', trans('forum::messages.discussions.status.deleted'));
    }
}
