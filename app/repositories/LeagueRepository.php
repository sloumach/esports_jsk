<?php

namespace App\Repositories;

use App\Models\League;
use Illuminate\Database\Eloquent\Collection;

class LeagueRepository
{
    public function all(): Collection
    {
        return League::with(['discipline', 'teams'])->get();
    }

    public function findById(int $id): ?League
    {
        return League::with(['discipline', 'teams'])->find($id);
    }

    public function create(array $data): League
    {
        return League::create($data);
    }

    public function update(League $league, array $data): League
    {
        $league->update($data);
        return $league;
    }

    public function delete(League $league): void
    {
        $league->delete();
    }

    public function attachTeam(League $league, int $teamId): void
    {
        $league->teams()->syncWithoutDetaching([$teamId => ['points' => 0]]);
    }

    public function detachTeam(League $league, int $teamId): void
    {
        $league->teams()->detach($teamId);
    }

    public function updatePoints(League $league, int $teamId, int $points): void
    {
        $league->teams()->updateExistingPivot($teamId, ['points' => $points]);
    }
}
