<?php

namespace App\Repositories;

use App\Models\Discipline;
use Illuminate\Database\Eloquent\Collection;

class DisciplineRepository
{
    public function all(): Collection
    {
        return Discipline::with('teams')->get();
    }

    public function findById(int $id): ?Discipline
    {
        return Discipline::with('teams')->find($id);
    }

    public function create(array $data): Discipline
    {
        return Discipline::create($data);
    }

    public function update(Discipline $discipline, array $data): Discipline
    {
        $discipline->update($data);
        return $discipline;
    }

    public function delete(Discipline $discipline): void
    {
        $discipline->delete();
    }
}
