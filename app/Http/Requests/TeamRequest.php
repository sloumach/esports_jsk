<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeamRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'discipline_id' => ['required', 'exists:disciplines,id'],
            'name'          => ['required', 'string', 'max:100'],
            'tag'           => ['required', 'string', 'max:10', 'unique:teams,tag,' . $this->id],
            'logo'          => ['nullable', 'string', 'max:255'],
        ];
    }
}
