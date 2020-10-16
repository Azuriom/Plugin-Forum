<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\ForumUser;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        return view('forum::users.edit', [
            'user' => ForumUser::firstOrCreate(['user_id' => $request->user()->id]),
        ]);
    }

    public function update(Request $request)
    {
        $data = $this->validate($request, [
            'about' => ['nullable', 'string'],
            'website' => ['nullable', 'string', 'url', 'max:100'],
            'location' => ['nullable', 'string', 'max:50'],
            'discord' => ['nullable', 'string', 'max:40', 'regex:/^(.+)#(\d{4})$$/'],
            'twitter' => ['nullable', 'string', 'max:15', 'alpha_dash', 'regex:/^[A-Za-z0-9_]+$/'],
        ]);

        ForumUser::updateOrCreate(['user_id' => $request->user()->id], $data);

        return redirect()->route('forum.users.show', $request->user());
    }
}
