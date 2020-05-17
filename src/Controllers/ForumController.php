<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Category;
use Azuriom\Plugin\Forum\Models\Forum;

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
                $query->withCount('discussions');
            }
        ])->orderBy('position')->get();

        return view('forum::home', ['categories' => $categories]);
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
                'author', 'posts.author' => function ($query) {
                    $query->latest()->take(1);
                }
            ])
            ->withCount('posts')
            ->orderByDesc('is_pinned')
            ->paginate();

        $forum->setRelation('discussions', $discussions);

        $forum->load('category');

        return view('forum::show', [
            'forum' => $forum,
            'current' => $forum,
        ]);
    }
}
