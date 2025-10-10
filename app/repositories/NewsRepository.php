<?php

namespace App\Repositories;

use App\Models\News;
use Illuminate\Database\Eloquent\Collection;

class NewsRepository
{
    public function all(): Collection
    {
        return News::with('author')->latest()->get();
    }

    public function findById(int $id): ?News
    {
        return News::with('author')->find($id);
    }

    public function findBySlug(string $slug): ?News
    {
        return News::with('author')->where('slug', $slug)->first();
    }

    public function create(array $data): News
    {
        return News::create($data);
    }

    public function update(News $news, array $data): News
    {
        $news->update($data);
        return $news;
    }

    public function delete(News $news): void
    {
        $news->delete();
    }
}
