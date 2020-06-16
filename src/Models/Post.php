<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\User as BaseUser;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Azuriom\Plugin\Forum\Support\Markdown;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;

/**
 * @property int $id
 * @property int $author_id
 * @property int $discussion_id
 * @property string $content
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Azuriom\Models\User $author
 * @property \Azuriom\Plugin\Forum\Models\Discussion $discussion
 */
class Post extends Model
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
        'content',
    ];

    /**
     * The user key associated with this model.
     *
     * @var string
     */
    protected $userKey = 'author_id';

    protected static function booted()
    {
        static::updated(function (Model $model) {
            Cache::forget("forum.posts-content.{$model->getKey()}");
        });
    }

    /**
     * Get the the author of this discussion.
     */
    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get this post likes.
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLiked(BaseUser $user = null)
    {
        if ($user === null && Auth::guest()) {
            return false;
        }

        $userId = $user ? $user->id : Auth::id();

        if ($this->relationLoaded('likes')) {
            return $this->likes->contains('author_id', $userId);
        }

        return $this->likes()->where('author_id', $userId)->exists();
    }

    public static function nextPostTime(BaseUser $user)
    {
        $lastPost = self::where('author_id', $user->id)
            ->where('created_at', '>', now()->subSeconds(forum_post_delay()))
            ->latest()
            ->first();

        if ($lastPost === null) {
            return null;
        }

        return $lastPost->created_at->addSeconds(forum_post_delay())->longAbsoluteDiffForHumans();
    }

    public function parseContent()
    {
        $cacheKey = "forum.posts-content.{$this->id}";

        return new HtmlString(Cache::remember($cacheKey, now()->addMinutes(15), function () {
            return Markdown::parse($this->content);
        }));
    }

    public function getParentNavigation()
    {
        return $this->discussion;
    }

    public function getNavigationLink()
    {
        return route('forum.discussions.show', $this->discussion);
    }
}
