<?php

namespace Azuriom\Plugin\Forum\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Forum\Models\Forum;
use Illuminate\Auth\Access\HandlesAuthorization;

class ForumPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any forums.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the forum.
     */
    public function view(?User $user, Forum $forum): bool
    {
        if ($forum->roles === null) {
            return true;
        }

        return $user !== null && $forum->hasRole($user->role);
    }

    /**
     * Determine whether the user can create forums.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the forum.
     */
    public function update(User $user, Forum $forum): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the forum.
     */
    public function delete(User $user, Forum $forum): bool
    {
        return true;
    }
}
