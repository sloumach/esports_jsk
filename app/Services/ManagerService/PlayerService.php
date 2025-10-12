<?php

namespace App\Services\ManagerService;

use App\Models\Player;
use App\Repositories\PlayerRepository;

class PlayerService
{
    public function __construct(
        private PlayerRepository $playerRepository
    ) {}

    public function list()
    {
        return $this->playerRepository->all();
    }

    public function get(int $id): ?Player
    {
        return $this->playerRepository->findById($id);
    }

    public function create(array $data): Player
    {
        return $this->playerRepository->create($data);
    }

    public function update(Player $player, array $data): Player
    {
        return $this->playerRepository->update($player, $data);
    }

    public function delete(Player $player): void
    {
        $this->playerRepository->delete($player);
    }
}
