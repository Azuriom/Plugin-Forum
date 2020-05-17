<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\User as BaseUser;

class User extends BaseUser
{
    /**
     * Get this user forum likes.
     */
    public function likes()
    {
        return $this->hasMany(Like::class, 'author_id');
    }

    /**
     * Get this user forum discussions.
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'author_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }
}
