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
     *
     * @param  \Azuriom\Models\User|null  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the forum.
     *
     * @param  \Azuriom\Models\User|null  $user
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return mixed
     */
    public function view(?User $user, Forum $forum)
    {
        if ($forum->roles === null) {
            return true;
        }

        return $user !== null && $forum->hasRole($user->role);
    }

    /**
     * Determine whether the user can create forums.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the forum.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return mixed
     */
    public function update(User $user, Forum $forum)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the forum.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Forum  $forum
     * @return mixed
     */
    public function delete(User $user, Forum $forum)
    {
        return true;
    }
}
