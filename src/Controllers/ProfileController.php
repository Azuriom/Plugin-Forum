<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\ForumUser;
use Azuriom\Plugin\Forum\Requests\UserRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('forum::users.edit', [
            'user' => ForumUser::firstOrCreate(['user_id' => $request->user()->id]),
        ]);
    }

    public function update(UserRequest $request)
    {
        ForumUser::updateOrCreate([
            'user_id' => $request->user()->id,
        ], $request->validated());

        return to_route('forum.users.show', $request->user());
    }
}
