<?php

/*
|--------------------------------------------------------------------------
| Helper functions
|--------------------------------------------------------------------------
|
| Here is where you can register helpers for your plugin. These
| functions are loaded by Composer and are globally available on the app !
| Just make sure you verify that a function doesn't exist before registering it
| to prevent any side effect.
|
*/

use Azuriom\Plugin\Forum\Models\Post;

if (! function_exists('forum_post_delay')) {
    /**
     * Return the delay in seconds before the user can post a second message.
     */
    function forum_post_delay(): int
    {
        return (int) setting('forum.post_delay', 60);
    }
}

if (! function_exists('forum_recent_posts')) {
    function forum_recent_posts()
    {
        return Post::with(['author', 'discussion'])
            ->latest()
            ->take(5)
            ->get();
    }
}
