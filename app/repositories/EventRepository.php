<?php

namespace App\Repositories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Collection;

class EventRepository
{
    public function all(): Collection
    {
        return Event::with('creator')->orderBy('start_date', 'desc')->get();
    }

    public function findById(int $id): ?Event
    {
        return Event::with('creator')->find($id);
    }

    public function create(array $data): Event
    {
        return Event::create($data);
    }

    public function update(Event $event, array $data): Event
    {
        $event->update($data);
        return $event;
    }

    public function delete(Event $event): void
    {
        $event->delete();
    }
}
