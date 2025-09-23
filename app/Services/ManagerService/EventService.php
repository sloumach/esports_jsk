<?php

namespace App\Services\ManagerService;

use App\Models\Event;
use App\Repositories\EventRepository;

class EventService
{
    public function __construct(
        private EventRepository $eventRepository
    ) {}

    public function list()
    {
        return $this->eventRepository->all();
    }

    public function get(int $id): ?Event
    {
        return $this->eventRepository->findById($id);
    }

    public function create(array $data): Event
    {
        return $this->eventRepository->create($data);
    }

    public function update(Event $event, array $data): Event
    {
        return $this->eventRepository->update($event, $data);
    }

    public function delete(Event $event): void
    {
        $this->eventRepository->delete($event);
    }
}
