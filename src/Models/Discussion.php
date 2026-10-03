<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\AttachableParent;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\Traits\Searchable;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Builder;
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
 * @property \Azuriom\Plugin\Forum\Models\Discussion $firstPost
 * @property \Azuriom\Plugin\Forum\Models\Poll|null $poll
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Post[] $posts
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Post[] $tags
 */
class Discussion extends Model
{
    use AttachableParent;
    use HasParentNavigation;
    use HasTablePrefix;
    use HasUser;
    use Loggable;
    use Searchable;

    /**
     * The relation name from this parent class to the class with attachments.
     */
    protected static string $attachableRelation = 'posts';

    /**
     * The actions to automatically log.
     */
    protected static array $logEvents = [
        'deleted',
    ];

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'forum_';

    /**
     * The user key associated with this model.
     */
    protected string $userKey = 'author_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title', 'views', 'is_pinned', 'is_locked',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_pinned' => 'boolean',
        'is_locked' => 'boolean',
    ];

    /**
     * The attributes that can be used for search.
     *
     * @var array<int, string>
     */
    protected array $searchable = [
        'title',
    ];

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

    /**
     * Get the poll associated with this discussion.
     */
    public function poll()
    {
        return $this->hasOne(Poll::class);
    }

    /**
     * Get the first post of this discussion.
     */
    public function firstPost()
    {
        return $this->hasOne(Post::class)->oldestOfMany();
    }

    /**
     * Check if this discussion has a poll.
     */
    public function hasPoll(): bool
    {
        return $this->poll !== null;
    }

    public function getParentNavigation(): ?Forum
    {
        return $this->forum;
    }

    public function scopePubliclyVisible(Builder $query): void
    {
        $query->where(fn (Builder $q) => $q
            ->where('is_pinned', true)
            ->orWhereHas('forum', fn (Builder $q) => $q->where('is_private', false))
        );
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

    public function getRoutePathAttribute(): string
    {
        return $this->id.'/'.Str::slug($this->title);
    }

    public function getNavigationLink(): array
    {
        return [route('forum.discussions.show', $this) => $this->title];
    }
}
