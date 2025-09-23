<?php

namespace App\Services\ManagerService;

use App\Models\Page;
use App\Repositories\PageRepository;

class PageService
{
    public function __construct(
        private PageRepository $pageRepository
    ) {}

    public function list()
    {
        return $this->pageRepository->all();
    }

    public function get(int $id): ?Page
    {
        return $this->pageRepository->findById($id);
    }

    public function getBySlug(string $slug): ?Page
    {
        return $this->pageRepository->findBySlug($slug);
    }

    public function create(array $data): Page
    {
        return $this->pageRepository->create($data);
    }

    public function update(Page $page, array $data): Page
    {
        return $this->pageRepository->update($page, $data);
    }

    public function delete(Page $page): void
    {
        $this->pageRepository->delete($page);
    }
}
