<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $author_id
 * @property int $forum_id
 * @property string $title
 * @property int $views
 * @property bool $is_pinned
 * @property bool $is_locked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Forum\Models\Forum $forum
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Post[] $posts
 */
class Discussion extends Model
{
    use HasParentNavigation;
    use HasTablePrefix;
    use HasUser;
    use Loggable;
    use Searchable;

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
        'title', 'views',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    /**
     * The attributes that can be search for.
     *
     * @var array
     */
    protected $searchable = [
        'title',
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'author_id';

    /**
     * Get the author of this discussion.
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
        return $this->hasMany(Post::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'forum_discussion_tag');
    }

    public function getParentNavigation()
    {
        return $this->forum;
    }

    /**
     * Retrieve the model for a bound value.
     *
     * @param  mixed  $value
     * @param  string|null  $field
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function resolveRouteBinding($value, $field = null)
    {
        if ($field === 'routePath') {
            $field = 'id';
        }

        return parent::resolveRouteBinding($value, $field);
    }

    public function getRoutePathAttribute()
    {
        return $this->id.'/'.Str::slug($this->title);
    }

    public function getNavigationLink()
    {
        return [route('forum.discussions.show', $this) => $this->title];
    }
}
