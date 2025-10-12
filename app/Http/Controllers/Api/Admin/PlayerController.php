<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PlayerRequest;
use App\Http\Resources\PlayerResource;
use App\Models\Player;
use App\Services\ManagerService\PlayerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class PlayerController extends Controller
{
    public function __construct(
        private PlayerService $playerService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(PlayerResource::collection($this->playerService->list()));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch players'], 500);
        }
    }

    public function store(PlayerRequest $request): JsonResponse
    {
        try {
            $player = $this->playerService->create($request->validated());
            return response()->json(new PlayerResource($player), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create player'], 500);
        }
    }

    public function show(Player $player): JsonResponse
    {
        try {
            return response()->json(new PlayerResource($player->load('teams')));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Player not found'], 404);
        }
    }

    public function update(PlayerRequest $request, Player $player): JsonResponse
    {
        try {
            $updated = $this->playerService->update($player, $request->validated());
            return response()->json(new PlayerResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update player'], 500);
        }
    }

    public function destroy(Player $player): JsonResponse
    {
        try {
            $this->playerService->delete($player);
            return response()->json(['message' => 'Player deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete player'], 500);
        }
    }

    /** Add or remove a player from a team **/
    public function attachToTeam(Request $request, Player $player): JsonResponse
    {
        try {
            $request->validate([
                'team_id'   => 'required|exists:teams,id',
                'joined_at' => 'nullable|date',
            ]);

            $player->teams()->attach($request->team_id, [
                'joined_at' => $request->joined_at ?? now(),
            ]);

            return response()->json(['message' => 'Player added to team successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to attach player to team'], 500);
        }
    }

    public function detachFromTeam(Request $request, Player $player): JsonResponse
    {
        try {
            $request->validate(['team_id' => 'required|exists:teams,id']);
            $player->teams()->detach($request->team_id);
            return response()->json(['message' => 'Player removed from team']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to detach player'], 500);
        }
    }
}
