<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'location'    => $this->location,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'banner'      => $this->banner ? asset('storage/' . $this->banner) : null,
            'creator'     => new UserResource($this->whenLoaded('creator')),
            'created_at'  => $this->created_at,
        ];
    }
}
