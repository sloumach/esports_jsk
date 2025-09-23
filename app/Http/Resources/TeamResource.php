<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'discipline' => new DisciplineResource($this->whenLoaded('discipline')),
            'name'       => $this->name,
            'tag'        => $this->tag,
            'logo'       => $this->logo,
            'wins'       => $this->wins,
            'losses'     => $this->losses,
            'players'    => $this->players->pluck('id'),
            'staff'      => $this->staff->pluck('id'),
        ];
    }
}
