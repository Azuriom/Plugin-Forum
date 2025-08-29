<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property int $discussion_id
 * @property string $question
 * @property bool $multiple_choice
 * @property bool $results_before_vote
 * @property bool $remove_vote
 * @property \Carbon\Carbon|null $closes_at
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Forum\Models\Discussion $discussion
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\PollOption[] $options
 */
class Poll extends Model
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
        'question', 'multiple_choice', 'results_before_vote', 'remove_vote', 'closes_at',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'multiple_choice' => 'boolean',
        'results_before_vote' => 'boolean',
        'remove_vote' => 'boolean',
        'closes_at' => 'datetime',
    ];

    /**
     * Get the discussion that owns this poll.
     */
    public function discussion()
    {
        return $this->belongsTo(Discussion::class);
    }

    /**
     * Get the poll options.
     */
    public function options()
    {
        return $this->hasMany(PollOption::class, 'poll_id')->inverse('poll');
    }

    /**
     * Return all votes for this poll.
     */
    public function votes()
    {
        return $this->hasManyThrough(PollVote::class, PollOption::class, 'poll_id', 'option_id');
    }

    /**
     * Check if the poll is closed or not.
     */
    public function isClosed(): bool
    {
        return $this->closes_at !== null && $this->closes_at->isPast();
    }

    /**
     * Check if a user has voted.
     */
    public function hasVoted(?User $user): bool
    {
        if ($user === null) {
            return false;
        }

        $users = once(fn () => $this->votes()
            ->select('user_id')
            ->distinct()
            ->get()
            ->pluck('user_id'));

        return $users->contains($user->id);
    }

    public function canVote(User $user): bool
    {
        return ! $this->isClosed() && ! $this->hasVoted($user);
    }
}
