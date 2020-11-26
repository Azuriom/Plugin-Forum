<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Role;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $icon
 * @property string $slug
 * @property string|null $description
 * @property int|null $category_id
 * @property int|null $parent_id
 * @property int $position
 * @property array|null $roles
 * @property bool $is_locked
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Azuriom\Plugin\Forum\Models\Category $category
 * @property \Azuriom\Plugin\Forum\Models\Forum|null $parent
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Discussion[] $discussions
 *
 * @method static \Illuminate\Database\Eloquent\Builder parents()
 */
class Forum extends Model
{
    use HasTablePrefix;
    use HasParentNavigation;
    use Loggable;

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
        'name', 'icon', 'description', 'slug', 'position', 'roles', 'category_id', 'parent_id', 'is_locked',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'roles' => 'array',
        'is_locked' => 'boolean',
    ];

    /**
     * Get the category of this forum.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the parent forum of this forum.
     */
    public function parent()
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * Get the parents forums in this forum.
     */
    public function forums()
    {
        return $this->hasMany(self::class, 'parent_id')->orderBy('position');
    }

    /**
     * Get the discussions in this forum.
     */
    public function discussions()
    {
        return $this->hasMany(Discussion::class);
    }

    /**
     * Get all the posts in this forum.
     */
    public function posts()
    {
        return $this->hasManyThrough(Post::class, Discussion::class)->latest();
    }

    public function hasRole(Role $role)
    {
        return in_array($role->id, $this->roles, true);
    }

    public function getParentNavigation()
    {
        return $this->parent ?? $this->category;
    }

    public function getNavigationLink()
    {
        return [route('forum.show', $this->slug) => $this->name];
    }

    /**
     * Scope a query to only include parent forums.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeParents(Builder $query)
    {
        return $query->whereNull('parent_id')->orderBy('position');
    }
}
