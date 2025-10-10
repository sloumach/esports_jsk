<?php

namespace App\Services\ManagerService;

use App\Models\StaffRole;
use App\Repositories\StaffRoleRepository;

class StaffRoleService
{
    public function __construct(
        private StaffRoleRepository $staffRoleRepository
    ) {}

    public function list()
    {
        return $this->staffRoleRepository->all();
    }

    public function get(int $id): ?StaffRole
    {
        return $this->staffRoleRepository->findById($id);
    }

    public function create(array $data): StaffRole
    {
        return $this->staffRoleRepository->create($data);
    }

    public function update(StaffRole $role, array $data): StaffRole
    {
        return $this->staffRoleRepository->update($role, $data);
    }

    public function delete(StaffRole $role): void
    {
        $this->staffRoleRepository->delete($role);
    }
}
