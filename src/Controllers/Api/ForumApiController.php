<?php

namespace Azuriom\Plugin\Forum\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Resources\CategoryResource;
use Azuriom\Plugin\Forum\Resources\DiscussionResource;
use Azuriom\Plugin\Forum\Resources\ForumResource;
use Azuriom\Plugin\Forum\Resources\PostResource;
use Illuminate\Database\Eloquent\Builder;

class ForumApiController extends Controller
{
    /**
     * List public categories.
     */
    public function categories()
    {
        $categories = Category::with('forums')->orderBy('position')->get();

        return CategoryResource::collection($categories);
    }

    /**
     * Display a public forum.
     */
    public function forum(Forum $forum)
    {
        $this->authorize('view', $forum);

        return new ForumResource($forum->load(['category', 'forums']));
    }

    /**
     * List discussions from a public forum.
     */
    public function discussions(Forum $forum)
    {
        $this->authorize('view', $forum);

        $discussions = $forum->discussions()
            ->scopes('publiclyVisible')
            ->with(['author', 'forum', 'tags'])
            ->latest('updated_at')
            ->paginate();

        return DiscussionResource::collection($discussions);
    }

    /**
     * List latest public discussions.
     */
    public function latest()
    {
        $discussions = Discussion::query()
            ->scopes('publiclyVisible')
            ->whereHas('forum', fn (Builder $q) => $q->where('is_private', false))
            ->with(['author', 'forum', 'tags'])
            ->latest('updated_at')
            ->paginate();

        return DiscussionResource::collection($discussions);
    }

    /**
     * Display a public discussion.
     */
    public function discussion(Discussion $discussion)
    {
        $this->authorize('view', $discussion);

        $discussion->load(['author', 'forum', 'tags']);

        return new DiscussionResource($discussion);
    }

    /**
     * List posts from a public discussion.
     */
    public function posts(Discussion $discussion)
    {
        $this->authorize('view', $discussion);

        $discussions = $discussion->posts()
            ->with('author')
            ->withCount('likes')
            ->oldest()
            ->paginate();

        return PostResource::collection($discussions);
    }
}
