<?php

namespace Azuriom\Plugin\Forum\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        return view('forum::admin.settings');
    }

    /**
     * Update the settings.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function save(Request $request)
    {
        $this->validate($request, [
            'post_delay' => ['nullable', 'integer', 'min:0'],
        ]);

        Setting::updateSettings('forum.post_delay', $request->input('post_delay'));

        return redirect()->route('forum.admin.settings')
            ->with('success', trans('admin.settings.status.updated'));
    }
}
