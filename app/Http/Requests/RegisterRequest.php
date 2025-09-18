<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'last_name'  => ['required', 'string', 'max:100'],
            'email'      => ['required', 'email', 'email:rfc,dns', 'unique:users,email'],
            'password'   => ['required', 'string', 'min:8', 'confirmed'],
            'locale'     => ['nullable', 'in:ar,fr,en'],
        ];
    }
}
