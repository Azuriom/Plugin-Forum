<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Plugin\Forum\Models\User;
use Illuminate\Support\Facades\Gate;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  \Azuriom\Plugin\Forum\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $user->load('user')->loadCount(['posts', 'likes', 'discussions']);

        $posts = $user->posts()
            ->with('discussion')
            ->take(15)
            ->get()
            ->filter(fn (Post $post) => Gate::allows('view', $post));

        return view('forum::users.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
