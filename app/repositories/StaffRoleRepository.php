<?php

namespace App\Repositories;

use App\Models\StaffRole;
use Illuminate\Database\Eloquent\Collection;

class StaffRoleRepository
{
    public function all(): Collection
    {
        return StaffRole::all();
    }

    public function findById(int $id): ?StaffRole
    {
        return StaffRole::find($id);
    }

    public function create(array $data): StaffRole
    {
        return StaffRole::create($data);
    }

    public function update(StaffRole $role, array $data): StaffRole
    {
        $role->update($data);
        return $role;
    }

    public function delete(StaffRole $role): void
    {
        $role->delete();
    }
}
