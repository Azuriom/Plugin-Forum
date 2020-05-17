<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Models\ActionLog;
use Azuriom\Plugin\Forum\Models\Discussion;

class DiscussionStatusController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('can:forum.discussions.manage');
    }

    public function lock(Discussion $discussion)
    {
        $discussion->forceFill(['is_locked' => true])->save();

        ActionLog::log('forum-discussions.locked', $discussion);

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.discussions.status.locked'));
    }

    public function unlock(Discussion $discussion)
    {
        $discussion->forceFill(['is_locked' => false])->save();

        ActionLog::log('forum-discussions.unlocked', $discussion);

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.discussions.status.unlocked'));
    }

    public function pin(Discussion $discussion)
    {
        $discussion->forceFill(['is_pinned' => true])->save();

        ActionLog::log('forum-discussions.pinned', $discussion);

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.discussions.status.pinned'));
    }

    public function unpin(Discussion $discussion)
    {
        $discussion->forceFill(['is_pinned' => false])->save();

        ActionLog::log('forum-discussions.unpinned', $discussion);

        return redirect()->route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.discussions.status.unpinned'));
    }
}
