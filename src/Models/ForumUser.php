<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasMarkdown;
use Azuriom\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\HtmlString;

/**
 * @property int $id
 * @property int $user_id
 * @property \Carbon\Carbon $last_seen_at
 * @property string|null $about
 * @property string|null $signature
 * @property string|null $website
 * @property string|null $location
 * @property string|null $discord
 * @property string|null $twitter
 * @property bool $display_last_seen
 * @property \Azuriom\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder online()
 */
class ForumUser extends Model
{
    use HasMarkdown;
    use HasUser;

    /**
     * The table associated with the model.
     */
    protected $table = 'forum_users';

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'last_seen_at', 'about', 'signature', 'website', 'location', 'discord',
        'twitter', 'display_last_seen',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'last_seen_at' => 'datetime',
        'display_last_seen' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parseAbout(): ?HtmlString
    {
        return $this->parseMarkdown('about');
    }

    public function parseSignature(): ?HtmlString
    {
        return $this->parseMarkdown('signature');
    }

    /**
     * Scope a query to only include online users.
     */
    public function scopeOnline(Builder $query): void
    {
        $query->where('last_seen_at', '>', now()->subMinutes(10));
    }
}
