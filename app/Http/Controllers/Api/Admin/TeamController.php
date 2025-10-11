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

            return response()->json(
                TeamResource::collection($this->teamService->list())
            );

    }

    public function store(TeamRequest $request): JsonResponse
    {

            $team = $this->teamService->create($request->validated());
            return response()->json(new TeamResource($team), 201);

    }

    public function show(Team $team): JsonResponse
    {

            return response()->json(new TeamResource($team));

    }

    public function update(TeamRequest $request, Team $team): JsonResponse
    {

            $updated = $this->teamService->update($team, $request->validated());
            return response()->json(new TeamResource($updated));

    }

    public function destroy(Team $team): JsonResponse
    {

            $this->teamService->delete($team);
            return response()->json(['message' => 'Team deleted successfully']);

    }

    /* ===== Custom endpoints for players & staff ===== */

    public function addPlayer(Request $request, Team $team): JsonResponse
    {

            $request->validate(['user_id' => 'required|uuid|exists:users,id']);
            $this->teamService->addPlayer($team, $request->user_id);
            return response()->json(['message' => 'Player added successfully']);

    }

    public function removePlayer(Request $request, Team $team): JsonResponse
    {

            $request->validate(['user_id' => 'required|uuid|exists:users,id']);
            $this->teamService->removePlayer($team, $request->user_id);
            return response()->json(['message' => 'Player removed successfully']);

    }

    public function addStaff(Request $request, Team $team): JsonResponse
    {

            $request->validate([
                'user_id' => 'required|uuid|exists:users,id',
                'staff_role_id' => 'nullable|exists:staff_roles,id'
            ]);
            $this->teamService->addStaff($team, $request->user_id, $request->staff_role_id);
            return response()->json(['message' => 'Staff added successfully']);

    }

    public function removeStaff(Request $request, Team $team): JsonResponse
    {

            $request->validate(['user_id' => 'required|uuid|exists:users,id']);
            $this->teamService->removeStaff($team, $request->user_id);
            return response()->json(['message' => 'Staff removed successfully']);

    }
}
