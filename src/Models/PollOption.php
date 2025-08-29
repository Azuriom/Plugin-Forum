<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $poll_id
 * @property string $value
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Forum\Models\Poll $poll
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\PollVote[] $votes
 */
class PollOption extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'forum_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'value',
    ];

    /**
     * Get the poll that owns this option.
     */
    public function poll()
    {
        return $this->belongsTo(Poll::class);
    }

    /**
     * Get the votes for this option.
     */
    public function votes()
    {
        return $this->hasMany(PollVote::class, 'option_id');
    }

    public function percentage(): int
    {
        $totalVote = $this->poll->options->sum('votes_count');
        $optionVote = $this->hasAttribute('votes_count')
            ? $this->votes_count
            : $this->votes()->count();

        return $totalVote > 0 ? (int) round(($optionVote / $totalVote) * 100) : 0;
    }
}
