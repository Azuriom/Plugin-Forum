<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Casts\Color;
use Azuriom\Models\Role;
use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\User;
use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $color
 * @property int $position
 * @property array|null $roles
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
        'name', 'color', 'position', 'roles',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'color' => Color::class,
        'roles' => 'array',
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

    public function hasRole(Role $role): bool
    {
        if ($this->roles === null) {
            return false;
        }

        return in_array($role->id, $this->roles, true);
    }

    public function userCanUse(?User $user = null)
    {
        if ($this->roles === null) {
            return true;
        }

        $user = $user ?? auth()->user();

        if ($user === null) {
            return false;
        }

        return $user->isAdmin() || $this->hasRole($user->role);
    }

    public function setRolesAttribute(?array $roles): void
    {
        $this->attributes['roles'] = optional($roles, function (array $roles) {
            return Json::encode(array_map(fn ($val) => (int) $val, $roles));
        });
    }
}
