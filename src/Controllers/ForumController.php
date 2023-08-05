<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\ForumUser;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\HtmlString;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::with([
            'forums' => function ($query) {
                $query->scopes('parents')->withCount(['discussions', 'posts']);
            },
        ])
            ->orderBy('position')
            ->get()
            ->filter(function (Category $category) {
                return ! $category->forums
                    ->filter(fn (Forum $forum) => Gate::allows('view', $forum))
                    ->isEmpty();
            });

        $stats = Cache::remember('forum.stats', now()->addMinutes(5), function () {
            $onlineUsers = ForumUser::online()
                ->with([
                    'user' => fn ($query) => $query->without('role'),
                ])
                ->get()
                ->pluck('user');

            return [
                'discussionsCount' => Discussion::count(),
                'postsCount' => Post::count(),
                'usersCount' => User::count(),
                'onlineUsers' => $onlineUsers,
            ];
        });

        $maxPosts = (int) setting('forum.recent_posts', 3);
        $homeMessage = setting('forum.home_message');

        $latestPosts = Post::with(['author', 'discussion'])
            ->latest()
            ->take($maxPosts * 2)
            ->get()
            ->filter(fn (Post $post) => Gate::allows('view', $post))
            ->take($maxPosts);

        return view('forum::home', [
            'homeMessage' => $homeMessage ? new HtmlString($homeMessage) : null,
            'categories' => $categories,
            'latestPosts' => $latestPosts,
            'user' => auth()->user(),
        ] + $stats);
    }

    /**
     * Display the specified resource.
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Forum $forum)
    {
        $this->authorize('view', $forum);

        $search = request()?->input('search');
        $hideDiscussions = $forum->is_private && ! Gate::allows('forum.private.view');

        $discussions = $forum->discussions()
            ->when($hideDiscussions, function (Builder $query) {
                $query->where(function (Builder $query) {
                    $query->where('author_id', auth()->id() ?? 0)->orWhere('is_pinned', true);
                });
            })
            ->when($search, function (Builder $query, string $search) {
                $query->scopes(['search' => $search]);
            })
            ->with([
                'author', 'tags',
                'posts' => fn (Builder $query) => $query->latest()->with('author'),
            ])
            ->withCount('posts')
            ->orderByDesc('is_pinned')
            ->latest()
            ->paginate();

        $forum->setRelation('discussions', $discussions);

        $forum->load([
            'category',
            'forums' => fn (Builder $query) => $query->withCount([
                'discussions', 'posts',
            ]),
        ]);

        return view('forum::show', [
            'forum' => $forum,
            'current' => $forum,
            'search' => $search,
        ]);
    }
}
