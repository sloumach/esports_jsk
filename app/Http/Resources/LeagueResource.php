<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LeagueResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'discipline'  => new DisciplineResource($this->whenLoaded('discipline')),
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'teams'       => $this->teams->map(function ($team) {
                return [
                    'id'     => $team->id,
                    'name'   => $team->name,
                    'tag'    => $team->tag,
                    'points' => $team->pivot->points,
                ];
            }),
            'created_at'  => $this->created_at,
        ];
    }
}
