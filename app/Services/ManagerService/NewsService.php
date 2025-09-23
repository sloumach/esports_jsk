<?php

namespace App\Services\ManagerService;

use App\Models\News;
use App\Repositories\NewsRepository;

class NewsService
{
    public function __construct(
        private NewsRepository $newsRepository
    ) {}

    public function list()
    {
        return $this->newsRepository->all();
    }

    public function get(int $id): ?News
    {
        return $this->newsRepository->findById($id);
    }

    public function getBySlug(string $slug): ?News
    {
        return $this->newsRepository->findBySlug($slug);
    }

    public function create(array $data): News
    {
        return $this->newsRepository->create($data);
    }

    public function update(News $news, array $data): News
    {
        return $this->newsRepository->update($news, $data);
    }

    public function delete(News $news): void
    {
        $this->newsRepository->delete($news);
    }
}
