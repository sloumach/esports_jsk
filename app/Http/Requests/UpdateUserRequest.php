<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'string', 'max:100'],
            'last_name'  => ['sometimes', 'string', 'max:100'],
            'email'      => ['sometimes', 'email', 'unique:users,email,' . $this->user->id],
            'password'   => ['sometimes', 'string', 'min:8', 'confirmed'],
            'phone'      => ['nullable', 'string', 'max:50'],
            'locale'     => ['nullable', 'in:ar,fr,en'],
            'status'     => ['nullable', 'in:active,inactive,banned'],
        ];
    }
}
