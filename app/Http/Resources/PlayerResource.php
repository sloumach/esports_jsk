<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlayerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'nickname'   => $this->nickname,
            'full_name'  => $this->full_name,
            'country'    => $this->country,
            'role'       => $this->role,
            'number'     => $this->number,
            'birth_date' => $this->birth_date,
            'teams'      => $this->whenLoaded('teams', function () {
                return $this->teams->map(fn($team) => [
                    'id'   => $team->id,
                    'name' => $team->name,
                    'tag'  => $team->tag,
                    'joined_at' => $team->pivot->joined_at,
                    'left_at'   => $team->pivot->left_at,
                ]);
            }),
        ];
    }
}
