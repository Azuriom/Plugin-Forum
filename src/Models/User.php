<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\User as BaseUser;
use Illuminate\Support\HtmlString;

/**
 * @property \Azuriom\Plugin\Forum\Models\ForumUser $user
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Like[] $likes
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Discussion[] $discussions
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Post[] $posts
 */
class User extends BaseUser
{
    public function getSignatureAttribute(): ?string
    {
        return $this->user->signature;
    }

    public function parseSignature(): ?HtmlString
    {
        return $this->user->parseSignature();
    }

    /**
     * Get this user forum likes.
     */
    public function likes()
    {
        return $this->hasManyThrough(Like::class, Post::class, 'author_id');
    }

    /**
     * Get this user forum discussions.
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class, 'author_id');
    }

    /**
     * Get the posts of this user.
     */
    public function posts()
    {
        return $this->hasMany(Post::class, 'author_id');
    }

    public function user()
    {
        return $this->hasOne(ForumUser::class, 'user_id')->withDefault();
    }
}
