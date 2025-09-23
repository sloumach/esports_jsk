<?php

namespace App\Repositories;

use App\Models\Role;

class RoleRepository
{
    public function findByName(string $name): ?Role
    {
        return Role::where('name', $name)->first();
    }

    public function assignRoleToUser(Role $role, $user): void
    {
        $user->roles()->syncWithoutDetaching([$role->id]);
    }

    public function removeRoleFromUser(Role $role, $user): void
    {
        $user->roles()->detach($role->id);
    }
}
