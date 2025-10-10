<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\TeamRequest;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use App\Services\ManagerService\TeamService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class TeamController extends Controller
{
    public function __construct(
        private TeamService $teamService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(
                TeamResource::collection($this->teamService->list())
            );
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch teams'], 500);
        }
    }

    public function store(TeamRequest $request): JsonResponse
    {
        try {
            $team = $this->teamService->create($request->validated());
            return response()->json(new TeamResource($team), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create team'], 500);
        }
    }

    public function show(Team $team): JsonResponse
    {
        try {
            return response()->json(new TeamResource($team));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Team not found'], 404);
        }
    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {
        try {
            $updated = $this->teamService->update($team, $request->validated());
            return response()->json(new TeamResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update team'], 500);
        }
    }

    public function destroy(Team $team): JsonResponse
    {
        try {
            $this->teamService->delete($team);
            return response()->json(['message' => 'Team deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete team'], 500);
        }
    }

    /* ===== Custom endpoints for players & staff ===== */

    public function addPlayer(Request $request, Team $team): JsonResponse
    {
        try {
            $request->validate(['user_id' => 'required|uuid|exists:users,id']);
            $this->teamService->addPlayer($team, $request->user_id);
            return response()->json(['message' => 'Player added successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to add player'], 500);
        }
    }

    public function removePlayer(Request $request, Team $team): JsonResponse
    {
        try {
            $request->validate(['user_id' => 'required|uuid|exists:users,id']);
            $this->teamService->removePlayer($team, $request->user_id);
            return response()->json(['message' => 'Player removed successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to remove player'], 500);
        }
    }

    public function addStaff(Request $request, Team $team): JsonResponse
    {
        try {
            $request->validate([
                'user_id' => 'required|uuid|exists:users,id',
                'staff_role_id' => 'nullable|exists:staff_roles,id'
            ]);
            $this->teamService->addStaff($team, $request->user_id, $request->staff_role_id);
            return response()->json(['message' => 'Staff added successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to add staff'], 500);
        }
    }

    public function removeStaff(Request $request, Team $team): JsonResponse
    {
        try {
            $request->validate(['user_id' => 'required|uuid|exists:users,id']);
            $this->teamService->removeStaff($team, $request->user_id);
            return response()->json(['message' => 'Staff removed successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to remove staff'], 500);
        }
    }
}
