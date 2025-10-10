<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PageRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'slug'    => ['required', 'string', 'max:150', 'unique:pages,slug,' . ($this->page->id ?? 'NULL')],
            'title'   => ['required', 'array'],
            'content' => ['required', 'array'],
        ];
    }
}
