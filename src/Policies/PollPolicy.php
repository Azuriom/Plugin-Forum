<?php

namespace Azuriom\Plugin\Forum\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Forum\Models\Poll;
use Illuminate\Auth\Access\HandlesAuthorization;

class PollPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the poll.
     */
    public function delete(User $user, Poll $poll): bool
    {
        return $user->can('forum.discussions') || $poll->discussion->author->is($user);
    }
}
