<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasUser;
use Azuriom\Plugin\Forum\Models\Traits\HasMarkdownOrBBCode;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

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
 *
 * @property \Azuriom\Models\User $user
 *
 * @method static \Illuminate\Database\Eloquent\Builder online()
 */
class ForumUser extends Model
{
    use HasMarkdownOrBBCode;
    use HasUser;

    /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'forum_users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'last_seen_at', 'about', 'signature', 'website', 'location', 'discord', 'twitter',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parseAbout()
    {
        return $this->parseMarkdown('about');
    }

    public function parseSignature()
    {
        return $this->parseMarkdown('signature');
    }

    /**
     * Scope a query to only include online users.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnline(Builder $query)
    {
        return $query->where('last_seen_at', '>', now()->subMinutes(10));
    }
}
