<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DisciplineRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'        => ['required', 'string', 'max:100'],
            'slug'        => ['required', 'string', 'max:120', 'unique:disciplines,slug,' . $this->id],
            'description' => ['nullable', 'string'],
            'logo' => ['nullable', 'image', 'max:2048'], // max 2MB
        ];
    }
}
