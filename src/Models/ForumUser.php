<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $user_id
 * @property \Carbon\Carbon $last_seen_at
 *
 * @property \Azuriom\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder online()
 */
class ForumUser extends Model
{
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
        'last_seen_at',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
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
