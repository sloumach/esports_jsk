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
        try {
            return response()->json(EventResource::collection($this->eventService->list()));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch events'], 500);
        }
    }

    public function store(EventRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('banner')) {
                $data['banner'] = $request->file('banner')->store('events', 'public');
            }

            $event = $this->eventService->create($data);
            return response()->json(new EventResource($event), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create event'], 500);
        }
    }

    public function show(Event $event): JsonResponse
    {
        try {
            return response()->json(new EventResource($event->load('creator')));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Event not found'], 404);
        }
    }

    public function update(EventRequest $request, Event $event): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('banner')) {
                $data['banner'] = $request->file('banner')->store('events', 'public');
            }

            $updated = $this->eventService->update($event, $data);
            return response()->json(new EventResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update event'], 500);
        }
    }

    public function destroy(Event $event): JsonResponse
    {
        try {
            $this->eventService->delete($event);
            return response()->json(['message' => 'Event deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete event'], 500);
        }
    }
}
