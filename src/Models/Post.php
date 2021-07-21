<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasMarkdown;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Models\User as BaseUser;
use Azuriom\Notifications\AlertNotification;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

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
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Like[] $likes
 */
class Post extends Model
{
    use HasTablePrefix;
    use HasUser;
    use HasMarkdown;
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
        static::created(function (Post $post) {
            preg_match_all('/@(\w{3,25})/', $post->content, $matches);

            if (empty($matches[1])) {
                return;
            }

            $users = User::whereIn('name', $matches[1])->limit(10)->get();

            $notification = (new AlertNotification(trans('forum::messages.notifications.mention', [
                'user' => $post->author->name,
                'discussion' => $post->discussion->title,
            ])))->from($post->author);

            foreach ($users as $user) {
                if (!$user->is($post->author)) {
                    $user->notifications()->create($notification->toArray());
                }
            }
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

        $userId = $user->id ?? Auth::id();

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
        return $this->parseMarkdown('content');
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
