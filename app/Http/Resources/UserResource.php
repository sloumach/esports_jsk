<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'username'   => $this->username,
            'email'      => $this->email,
            'phone'      => $this->phone,
            'locale'     => $this->locale,
            'status'     => $this->status,
            'roles'      => $this->roles->pluck('name'),
            'last_login' => $this->last_login_at,
            'created_at' => $this->created_at,
        ];
    }
}
