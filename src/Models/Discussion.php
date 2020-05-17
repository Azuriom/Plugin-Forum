<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $author_id
 * @property int $forum_id
 * @property string $title
 * @property bool $is_pinned
 * @property bool $is_locked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Forum\Models\Forum $forum
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Post[] $posts
 */
class Discussion extends Model
{
    use HasTablePrefix;
    use HasUser;
    use HasParentNavigation;
    use Loggable;

    /**
     * The actions to automatically log.
     *
     * @var array
     */
    protected static $logEvents = [
        'deleted',
    ];

    /**
     * The table prefix associated with the model.
     *
     * @var string
     */
    protected $prefix = 'forum_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'author_id';

    /**
     * Get the the author of this discussion.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    /**
     * Get the forum of this discussion.
     */
    public function forum()
    {
        return $this->belongsTo(Forum::class);
    }

    /**
     * Get the posts of this discussion.
     */
    public function posts()
    {
        return $this->hasMany(Post::class)->latest('updated_at');
    }

    public function getParentNavigation()
    {
        return $this->forum;
    }

    public function getNavigationLink()
    {
        return [route('forum.discussions.show', $this) => $this->title];
    }
}
