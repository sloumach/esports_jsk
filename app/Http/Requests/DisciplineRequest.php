<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplineRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => ['sometimes', 'string', 'max:100'],
            'slug'        => ['sometimes', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];
    }
}
