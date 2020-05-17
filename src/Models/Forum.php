<?php

namespace Azuriom\Plugin\Forum\Models;

use Azuriom\Models\Traits\HasTablePrefix;
use Azuriom\Models\Traits\Loggable;
use Azuriom\Plugin\Forum\Models\Traits\HasParentNavigation;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $description
 * @property int category_id
 * @property int $position
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 *
 * @property \Azuriom\Plugin\Forum\Models\Category $category
 * @property \Illuminate\Support\Collection|\Azuriom\Plugin\Forum\Models\Discussion[] $discussions
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
        'name', 'description', 'slug', 'position', 'category_id',
    ];

    /**
     * Get the category of this forum.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
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

    public function getParentNavigation()
    {
        return $this->category;
    }

    public function getNavigationLink()
    {
        return [route('forum.show', $this->slug) => $this->name];
    }
}
