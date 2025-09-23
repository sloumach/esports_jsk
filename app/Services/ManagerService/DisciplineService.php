<?php

namespace App\Services\ManagerService;

use App\Models\Discipline;
use App\Repositories\DisciplineRepository;

class DisciplineService
{
    public function __construct(
        private DisciplineRepository $disciplineRepository
    ) {}

    public function list()
    {
        return $this->disciplineRepository->all();
    }

    public function get(int $id): ?Discipline
    {
        return $this->disciplineRepository->findById($id);
    }

    public function create(array $data): Discipline
    {
        return $this->disciplineRepository->create($data);
    }

    public function update(Discipline $discipline, array $data): Discipline
    {
        return $this->disciplineRepository->update($discipline, $data);
    }

    public function delete(Discipline $discipline): void
    {
        $this->disciplineRepository->delete($discipline);
    }
}
