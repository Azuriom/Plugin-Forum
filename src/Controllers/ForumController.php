<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\User;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Azuriom\Plugin\Forum\Models\ForumUser;
use Azuriom\Plugin\Forum\Models\Post;
use Illuminate\Support\Facades\Cache;

class ForumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::with([
            'forums' => function ($query) {
                $query->scopes('parents')->withCount(['discussions', 'posts']);
            }
        ])->orderBy('position')->get();

        $stats = Cache::remember('forum.stats', now()->addMinutes(5), function () {
            $onlineUsers = ForumUser::online()
                ->with([
                    'user' => function ($query) {
                        $query->without('role');
                    }
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

        $latestPosts = Post::with(['author', 'discussion'])
            ->latest()
            ->take(3)
            ->get();

        return view('forum::home', [
                'categories' => $categories,
                'latestPosts' => $latestPosts,
            ] + $stats);
    }

    /**
     * Display the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return \Illuminate\Http\Response
     */
    public function show(Forum $forum)
    {
        $discussions = $forum->discussions()
            ->with([
                'author', 'posts' => function ($query) {
                    $query->latest()->with('author');
                }
            ])
            ->withCount('posts')
            ->orderByDesc('is_pinned')
            ->paginate();

        $forum->setRelation('discussions', $discussions);

        $forum->load([
            'category', 'forums' => function ($query) {
                $query->withCount(['discussions', 'posts']);
            },
        ]);

        return view('forum::show', [
            'forum' => $forum,
            'current' => $forum,
        ]);
    }
}
