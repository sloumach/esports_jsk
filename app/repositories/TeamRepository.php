<?php

namespace App\Repositories;

use App\Models\Team;
use Illuminate\Database\Eloquent\Collection;

class TeamRepository
{
    public function all(): Collection
    {
        return Team::with(['discipline', 'players', 'staff'])->get();
    }

    public function findById(int $id): ?Team
    {
        return Team::with(['discipline', 'players', 'staff'])->find($id);
    }

    public function create(array $data): Team
    {
        return Team::create($data);
    }

    public function update(Team $team, array $data): Team
    {
        $team->update($data);
        return $team;
    }

    public function delete(Team $team): void
    {
        $team->delete();
    }

    public function attachPlayer(Team $team, string $userId): void
    {
        $team->players()->syncWithoutDetaching([$userId => ['joined_at' => now()]]);
    }

    public function detachPlayer(Team $team, string $userId): void
    {
        $team->players()->detach($userId);
    }

    public function attachStaff(Team $team, string $userId, ?int $staffRoleId = null): void
    {
        $team->staff()->syncWithoutDetaching([
            $userId => ['staff_role_id' => $staffRoleId, 'assigned_at' => now()]
        ]);
    }

    public function detachStaff(Team $team, string $userId): void
    {
        $team->staff()->detach($userId);
    }
}
