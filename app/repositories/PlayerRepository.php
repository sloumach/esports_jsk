<?php

namespace App\Repositories;

use App\Models\Player;
use Illuminate\Database\Eloquent\Collection;

class PlayerRepository
{
    public function all(): Collection
    {
        return Player::with('teams')->get();
    }

    public function findById(int $id): ?Player
    {
        return Player::with('teams')->find($id);
    }

    public function create(array $data): Player
    {
        return Player::create($data);
    }

    public function update(Player $player, array $data): Player
    {
        $player->update($data);
        return $player;
    }

    public function delete(Player $player): void
    {
        $player->delete();
    }
}
