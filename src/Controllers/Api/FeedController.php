<?php

namespace Azuriom\Plugin\Forum\Controllers\Api;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class FeedController extends Controller
{
    private const FEED_LIMIT = 20;

    public function rss()
    {
        return $this->feed('rss');
    }

    public function atom()
    {
        return $this->feed('atom');
    }

    public function forumRss(Forum $forum)
    {
        $this->authorize('view', $forum);

        return $this->feed('rss', $forum);
    }

    public function forumAtom(Forum $forum)
    {
        $this->authorize('view', $forum);

        return $this->feed('atom', $forum);
    }

    protected function feed(string $format, ?Forum $forum = null)
    {
        $discussions = $this->getRecentDiscussions($forum);

        return response()->view("forum::feed.{$format}", [
            'title' => $forum !== null
                ? $forum->name.' - '.site_name()
                : site_name().' - '.trans('forum::messages.title'),
            'description' => $forum?->description,
            'forum' => $forum,
            'feedUrl' => request()->url(),
            'updatedAt' => $discussions->first()?->updated_at ?? now(),
            'discussions' => $discussions,
        ])
            ->header('Content-Type', "application/{$format}+xml; charset=UTF-8");
    }

    protected function getRecentDiscussions(?Forum $forum = null): Collection
    {
        $query = $forum === null
            ? Discussion::query()
                ->whereHas('forum', fn (Builder $q) => $q->whereNull('roles'))
            : $forum->discussions();

        return $query->scopes('publiclyVisible')
            ->with(['author', 'forum', 'firstPost'])
            ->withCount('posts')
            ->latest('updated_at')
            ->limit(self::FEED_LIMIT)
            ->get();
    }
}
