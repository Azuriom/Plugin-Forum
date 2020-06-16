<?php

namespace Azuriom\Plugin\Forum\Policies;

use Azuriom\Plugin\Forum\Models\Discussion;
use Azuriom\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscussionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any discussions.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the discussion.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Discussion  $discussion
     * @return mixed
     */
    public function view(?User $user, Discussion $discussion)
    {
        return true;
    }

    /**
     * Determine whether the user can create discussions.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
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
