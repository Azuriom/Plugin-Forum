<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $position
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Forum[] $forums
 */
class Category extends Model
{
    use HasParentNavigation;
    use HasTablePrefix;
    use Loggable;

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
        'name', 'description', 'position',
    ];

    /**
     * Get the forums in the category.
     */
    public function forums()
    {
        return $this->hasMany(Forum::class)->orderBy('position');
    }

    public function getNavigationLink(): array
    {
        return [route('forum.home') => $this->name];
    }
}
