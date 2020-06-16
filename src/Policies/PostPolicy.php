<?php

namespace Azuriom\Plugin\Forum\Policies;

use Azuriom\Plugin\Forum\Models\Post;
use Azuriom\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return mixed
     */
    public function view(?User $user, Post $post)
    {
        return true;
    }

    /**
     * Determine whether the user can create posts.
     *
     * @param  \Azuriom\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the post.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return mixed
     */
    public function update(User $user, Post $post)
    {
        return $user->is($post->author) || $user->can('forum.discussions');
    }

    /**
     * Determine whether the user can delete the post.
     *
     * @param  \Azuriom\Models\User  $user
     * @param  \Azuriom\Plugin\Forum\Models\Post  $post
     * @return mixed
     */
    public function delete(User $user, Post $post)
    {
        return $user->is($post->author) || $user->can('forum.discussions');
    }
}
