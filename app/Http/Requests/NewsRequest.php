<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title'       => ['required', 'array'],
            'content'     => ['required', 'array'],
            'slug'        => ['required', 'string', 'max:150', 'unique:news,slug,' . ($this->news->id ?? 'NULL')],
            'cover_image' => ['nullable', 'image', 'max:2048'],
            'author_id'   => ['required', 'exists:users,id'],
            'published_at'=> ['nullable', 'date'],
        ];
    }
}
