<?php

namespace App\Repositories;

use App\Models\Sponsor;
use Illuminate\Database\Eloquent\Collection;

class SponsorRepository
{
    public function all(): Collection
    {
        return Sponsor::all();
    }

    public function findById(int $id): ?Sponsor
    {
        return Sponsor::find($id);
    }

    public function create(array $data): Sponsor
    {
        return Sponsor::create($data);
    }

    public function update(Sponsor $sponsor, array $data): Sponsor
    {
        $sponsor->update($data);
        return $sponsor;
    }

    public function delete(Sponsor $sponsor): void
    {
        $sponsor->delete();
    }
}
