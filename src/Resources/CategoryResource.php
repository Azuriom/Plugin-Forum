<?php

namespace Azuriom\Plugin\Forum\Resources;

use Azuriom\Plugin\Forum\Models\Forum;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Azuriom\Plugin\Forum\Models\Category */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'position' => $this->position,
            'forums' => $this->whenLoaded('forums', fn () => ForumResource::collection(
                $this->forums->filter(fn (Forum $forum) => ! $forum->isRoleRestricted())->values(),
            )),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
