<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'           => $this->id,
            'title'        => $this->title,
            'content'      => $this->content,
            'slug'         => $this->slug,
            'cover_image'  => $this->cover_image ? asset('storage/' . $this->cover_image) : null,
            'author'       => new UserResource($this->whenLoaded('author')),
            'published_at' => $this->published_at,
            'created_at'   => $this->created_at,
        ];
    }
}
