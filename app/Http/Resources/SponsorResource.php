<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SponsorResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'      => $this->id,
            'name'    => $this->name,
            'logo'    => $this->logo ? asset('storage/' . $this->logo) : null,
            'website' => $this->website,
        ];
    }
}
