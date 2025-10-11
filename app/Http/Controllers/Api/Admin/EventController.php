<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Http\Resources\EventResource;
use App\Models\Event;
use App\Services\ManagerService\EventService;
use Illuminate\Http\JsonResponse;
use Throwable;

class EventController extends Controller
{
    public function __construct(
        private EventService $eventService
    ) {}

    public function index(): JsonResponse
    {

            return response()->json(EventResource::collection($this->eventService->list()));

    }

    public function store(EventRequest $request): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('banner')) {
                $data['banner'] = $request->file('banner')->store('events', 'public');
            }

            $event = $this->eventService->create($data);
            return response()->json(new EventResource($event), 201);

    }

    public function show(Event $event): JsonResponse
    {

            return response()->json(new EventResource($event->load('creator')));

    }

    public function update(EventRequest $request, Event $event): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('banner')) {
                $data['banner'] = $request->file('banner')->store('events', 'public');
            }

            $updated = $this->eventService->update($event, $data);
            return response()->json(new EventResource($updated));

    }

    public function destroy(Event $event): JsonResponse
    {

            $this->eventService->delete($event);
            return response()->json(['message' => 'Event deleted successfully']);

    }
}
