<?php

namespace Azuriom\Plugin\Forum\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Azuriom\Plugin\Forum\Models\Discussion */
class DiscussionResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'views' => $this->views,
            'is_pinned' => $this->is_pinned,
            'is_locked' => $this->is_locked,
            'author' => [
                'id' => $this->author?->id,
                'name' => $this->author?->name,
            ],
            'forum' => new ForumResource($this->whenLoaded('forum')),
            'posts_count' => $this->when(isset($this->posts_count), $this->posts_count),
            'tags' => $this->whenLoaded('tags', fn () => TagResource::collection($this->tags)),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
