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
 * @property array|null $default_tags
 * @property bool $is_locked
 * @property bool $is_private
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @property \Azuriom\Plugin\Forum\Models\Category $category
 * @property \Azuriom\Plugin\Forum\Models\Forum|null $parent
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Discussion[] $discussions
 *
 * @method static \Illuminate\Database\Eloquent\Builder parents()
 */
class Forum extends Model
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
        'name', 'icon', 'description', 'slug', 'position', 'roles', 'default_tags',
        'category_id', 'parent_id', 'is_locked', 'is_private',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'roles' => 'array',
        'default_tags' => 'array',
        'is_locked' => 'boolean',
        'is_private' => 'boolean',
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

    public function hasRole(Role $role): bool
    {
        if ($this->roles === null) {
            return false;
        }

        return in_array($role->id, $this->roles, true);
    }

    public function getParentNavigation(): ?Model
    {
        return $this->parent ?? $this->category;
    }

    public function getNavigationLink(): array
    {
        return [route('forum.show', $this->slug) => $this->name];
    }

    public function setRolesAttribute(?array $roles): void
    {
        $ids = $roles === null ? $roles : array_map(fn ($val) => (int) $val, $roles);

        $this->attributes['roles'] = json_encode($ids);
    }

    public function setDefaultTagsAttribute(?array $tags): void
    {
        $ids = $tags === null ? $tags : array_map(fn ($val) => (int) $val, $tags);

        $this->attributes['default_tags'] = json_encode($ids);
    }

    /**
     * Scope a query to only include parent forums.
     */
    public function scopeParents(Builder $query): void
    {
        $query->whereNull('parent_id')->orderBy('position');
    }
}
