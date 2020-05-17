<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $author_id
 * @property int $post_id
 *
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Forum\Models\Post $post
 */
class Like extends Model
{
    use HasTablePrefix;
    use HasUser;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'forum_';

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'author_id';

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
