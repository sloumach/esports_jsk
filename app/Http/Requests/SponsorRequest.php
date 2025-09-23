<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SponsorRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'   => ['required', 'string', 'max:150'],
            'logo'   => ['nullable', 'image', 'max:2048'],
            'website'=> ['nullable', 'string', 'max:255'],
        ];
    }
}
