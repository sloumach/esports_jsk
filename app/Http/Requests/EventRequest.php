<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => ['required', 'array'],
            'description' => ['nullable', 'array'],
            'location'    => ['nullable', 'string', 'max:255'],
            'start_date'  => ['required', 'date'],
            'end_date'    => ['required', 'date', 'after_or_equal:start_date'],
            'banner'      => ['nullable', 'image', 'max:2048'],
            'created_by'  => ['required', 'exists:users,id'],
        ];
    }
}
