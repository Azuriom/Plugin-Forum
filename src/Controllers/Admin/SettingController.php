<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class SettingController extends Controller
{
    /**
     * Display the settings.
     */
    public function show()
    {
        return view('forum::admin.settings', [
            'webhook' => setting('forum.webhook'),
            'editor' => setting('forum.editor'),
            'recentPosts' => setting('forum.recent_posts', 3),
            'homeMessage' => setting('forum.home_message'),
        ]);
    }

    /**
     * Update the settings.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $settings = $this->validate($request, [
            'post_delay' => ['nullable', 'integer', 'min:0'],
            'recent_posts' => ['nullable', 'integer', 'min:0'],
            'webhook' => ['nullable', 'url:http,https'],
            'home_message' => ['nullable', 'string'],
            'editor' => ['nullable', 'in:bbcode,markdown'],
        ]);

        Setting::updateSettings(Arr::prependKeysWith($settings, 'forum.'));

        return to_route('forum.admin.settings')
            ->with('success', trans('admin.settings.updated'));
    }
}
