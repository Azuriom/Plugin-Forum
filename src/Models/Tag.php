<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Casts\Color;
use Azuriom\Models\Traits\HasTablePrefix;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $position
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Discussion[] $discussions
 */
class Tag extends Model
{
    use HasTablePrefix;

    /**
     * The table prefix associated with the model.
     */
    protected string $prefix = 'forum_';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<string, string>
     */
    protected $fillable = [
        'name', 'color', 'position',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'color' => Color::class,
    ];

    public function discussions()
    {
        return $this->belongsToMany(Discussion::class, 'forum_discussion_tag');
    }

    public function getBadgeStyle(): string
    {
        $color = color_contrast($this->color);

        return "color: {$color}; background: {$this->color};";
    }
}
