<?php

namespace App\Services\ManagerService;

use App\Models\League;
use App\Repositories\LeagueRepository;

class LeagueService
{
    public function __construct(
        private LeagueRepository $leagueRepository
    ) {}

    public function list()
    {
        return $this->leagueRepository->all();
    }

    public function get(int $id): ?League
    {
        return $this->leagueRepository->findById($id);
    }

    public function create(array $data): League
    {
        return $this->leagueRepository->create($data);
    }

    public function update(League $league, array $data): League
    {
        return $this->leagueRepository->update($league, $data);
    }

    public function delete(League $league): void
    {
        $this->leagueRepository->delete($league);
    }

    public function addTeam(League $league, int $teamId): void
    {
        $this->leagueRepository->attachTeam($league, $teamId);
    }

    public function removeTeam(League $league, int $teamId): void
    {
        $this->leagueRepository->detachTeam($league, $teamId);
    }

    public function setTeamPoints(League $league, int $teamId, int $points): void
    {
        $this->leagueRepository->updatePoints($league, $teamId, $points);
    }
}
