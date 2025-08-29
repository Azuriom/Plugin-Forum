<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\HasUser;
use Azuriom\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $option_id
 * @property int|null $user_id
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Forum\Models\PollOption $option
 * @property \Azuriom\Models\User|null $user
 */
class PollVote extends Model
{
    use HasTablePrefix;
    use HasUser;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'forum_';

    /**
     * The user key associated with this model.
     */
    protected string $userKey = 'user_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'option_id', 'user_id',
    ];

    /**
     * Get the poll option that this vote belongs to.
     */
    public function option()
    {
        return $this->belongsTo(PollOption::class, 'option_id');
    }

    /**
     * Get the user who cast this vote.
     */
    public function user()
    {
        return $this->belongsTo(BaseUser::class);
    }
}
