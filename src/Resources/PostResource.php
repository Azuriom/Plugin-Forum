<?php

namespace Azuriom\Plugin\Forum\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \Azuriom\Plugin\Forum\Models\Post */
class PostResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'content' => $this->content,
            'likes_count' => $this->when(isset($this->likes_count), $this->likes_count),
            'author' => [
                'id' => $this->author?->id,
                'name' => $this->author?->name,
            ],
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
