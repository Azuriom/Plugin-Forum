<?php

namespace Azuriom\Plugin\Forum\Controllers;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\PollOption;
use Azuriom\Plugin\Forum\Requests\VoteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DiscussionPollController extends Controller
{
    /**
     * Vote on a poll.
     */
    public function vote(VoteRequest $request, Discussion $discussion)
    {
        abort_if(! $discussion->hasPoll(), 404);
        abort_if($discussion->poll->isClosed(), 403);

        $user = $request->user();

        if (! $discussion->poll->remove_vote && $discussion->poll->hasVoted($user)) {
            return redirect()->back();
        }

        $discussion->poll->votes()->whereBelongsTo($request->user())->delete();

        $discussion->poll->options()
            ->findMany($request->input('options', []))
            ->when(! $discussion->poll->multiple_choice, fn (Collection $c) => $c->take(1))
            ->each(fn (PollOption $option) => $option->votes()->create());

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.polls.voted'));
    }

    /**
     * Remove vote from a poll.
     */
    public function removeVote(Request $request, Discussion $discussion)
    {
        abort_if(! $discussion->hasPoll(), 404);

        if (! $discussion->poll->remove_vote || $discussion->poll->isClosed()) {
            return redirect()->back();
        }

        $discussion->poll->votes()->whereBelongsTo($request->user())->delete();

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.polls.vote_removed'));
    }

    /**
     * Delete a poll.
     */
    public function destroy(Discussion $discussion)
    {
        abort_if(! $discussion->hasPoll(), 404);

        $this->authorize('delete', $discussion->poll);

        $discussion->poll->delete();

        return to_route('forum.discussions.show', $discussion)
            ->with('success', trans('forum::messages.polls.deleted'));
    }
}
