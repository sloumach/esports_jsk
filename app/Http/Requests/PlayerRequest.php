<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PlayerRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nickname'  => ['required', 'string', 'max:50'],
            'full_name' => ['nullable', 'string', 'max:100'],
            'country'   => ['nullable', 'string', 'max:60'],
        ];
    }
}
