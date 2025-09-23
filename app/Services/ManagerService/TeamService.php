<?php

namespace App\Services\ManagerService;

use App\Models\Team;
use App\Repositories\TeamRepository;

class TeamService
{
    public function __construct(
        private TeamRepository $teamRepository
    ) {}

    public function list()
    {
        return $this->teamRepository->all();
    }

    public function get(int $id): ?Team
    {
        return $this->teamRepository->findById($id);
    }

    public function create(array $data): Team
    {
        return $this->teamRepository->create($data);
    }

    public function update(Team $team, array $data): Team
    {
        return $this->teamRepository->update($team, $data);
    }

    public function delete(Team $team): void
    {
        $this->teamRepository->delete($team);
    }

    public function addPlayer(Team $team, string $userId): void
    {
        $this->teamRepository->attachPlayer($team, $userId);
    }

    public function removePlayer(Team $team, string $userId): void
    {
        $this->teamRepository->detachPlayer($team, $userId);
    }

    public function addStaff(Team $team, string $userId, ?int $roleId = null): void
    {
        $this->teamRepository->attachStaff($team, $userId, $roleId);
    }

    public function removeStaff(Team $team, string $userId): void
    {
        $this->teamRepository->detachStaff($team, $userId);
    }
}
