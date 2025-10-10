<?php

namespace App\Services\ManagerService;

use App\Models\Sponsor;
use App\Repositories\SponsorRepository;

class SponsorService
{
    public function __construct(
        private SponsorRepository $sponsorRepository
    ) {}

    public function list()
    {
        return $this->sponsorRepository->all();
    }

    public function get(int $id): ?Sponsor
    {
        return $this->sponsorRepository->findById($id);
    }

    public function create(array $data): Sponsor
    {
        return $this->sponsorRepository->create($data);
    }

    public function update(Sponsor $sponsor, array $data): Sponsor
    {
        return $this->sponsorRepository->update($sponsor, $data);
    }

    public function delete(Sponsor $sponsor): void
    {
        $this->sponsorRepository->delete($sponsor);
    }
}
