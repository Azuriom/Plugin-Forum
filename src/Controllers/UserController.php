<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\User;

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
        $user->load(['user', 'posts.discussion'])->loadCount(['posts', 'likes', 'discussions']);

        return view('forum::users.show', ['user' => $user]);
    }
}
