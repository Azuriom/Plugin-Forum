<?php

namespace Azuriom\Plugin\Forum\Policies;

use Azuriom\Models\User;
use Azuriom\Plugin\Forum\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Support\Facades\Gate;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any posts.
     */
    public function viewAny(?User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the post.
     */
    public function view(?User $user, Post $post): bool
    {
        return Gate::allows('view', $post->discussion);
    }

    /**
     * Determine whether the user can create posts.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the post.
     */
    public function update(User $user, Post $post): bool
    {
        if (! $post->discussion->is_locked && $user->is($post->author)) {
            return true;
        }

        return $user->can('forum.discussions');
    }

    /**
     * Determine whether the user can delete the post.
     */
    public function delete(User $user, Post $post): bool
    {
        if (! $post->discussion->is_locked && $user->is($post->author)) {
            return true;
        }

        return $user->can('forum.discussions');
    }
}
