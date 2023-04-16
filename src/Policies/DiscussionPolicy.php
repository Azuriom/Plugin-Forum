<?php

namespace Azuriom\Plugin\Forum\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Plugin\Forum\Models\Forum;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class DiscussionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any discussions.
     *
     * @param  \Azuriom\Models\User|null  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the discussion.
     *
     * @param  \Azuriom\Models\User|null  $user
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return mixed
     */
    public function view(?User $user, Discussion $discussion)
    {
        if (! Gate::allows('view', $discussion->forum)) {
            return false;
        }

        if (! $discussion->forum->is_private || $discussion->is_pinned) {
            return true;
        }

        if ($user === null) {
            return false;
        }

        return $user->is($discussion->author) || $user->can('forum.private.view');
    }

    /**
     * Determine whether the user can create discussions.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return mixed
     */
    public function create(User $user, Forum $forum = null)
    {
        if ($forum === null) {
            return true;
        }

        return ! $forum->is_locked || $user->can('forum.locked.post');
    }

    /**
     * Determine whether the user can update the discussion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return mixed
     */
    public function update(User $user, Discussion $discussion)
    {
        return $user->is($discussion->author) || $user->can('forum.discussions');
    }

    /**
     * Determine whether the user can delete the discussion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return mixed
     */
    public function delete(User $user, Discussion $discussion)
    {
        return $user->can('forum.discussions');
    }
}
