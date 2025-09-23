<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LeagueRequest;
use App\Http\Resources\LeagueResource;
use App\Models\League;
use App\Services\ManagerService\LeagueService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class LeagueController extends Controller
{
    public function __construct(
        private LeagueService $leagueService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(LeagueResource::collection($this->leagueService->list()));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch leagues'], 500);
        }
    }

    public function store(LeagueRequest $request): JsonResponse
    {
        try {
            $league = $this->leagueService->create($request->validated());
            return response()->json(new LeagueResource($league), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create league'], 500);
        }
    }

    public function show(League $league): JsonResponse
    {
        try {
            return response()->json(new LeagueResource($league->load(['discipline', 'teams'])));
        } catch (Throwable $e) {
            return response()->json(['error' => 'League not found'], 404);
        }
    }

    public function update(LeagueRequest $request, League $league): JsonResponse
    {
        try {
            $updated = $this->leagueService->update($league, $request->validated());
            return response()->json(new LeagueResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update league'], 500);
        }
    }

    public function destroy(League $league): JsonResponse
    {
        try {
            $this->leagueService->delete($league);
            return response()->json(['message' => 'League deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete league'], 500);
        }
    }

    /* ===== Custom endpoints for teams in a league ===== */

    public function addTeam(Request $request, League $league): JsonResponse
    {
        try {
            $request->validate(['team_id' => 'required|exists:teams,id']);
            $this->leagueService->addTeam($league, $request->team_id);
            return response()->json(['message' => 'Team added to league']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to add team'], 500);
        }
    }

    public function removeTeam(Request $request, League $league): JsonResponse
    {
        try {
            $request->validate(['team_id' => 'required|exists:teams,id']);
            $this->leagueService->removeTeam($league, $request->team_id);
            return response()->json(['message' => 'Team removed from league']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to remove team'], 500);
        }
    }

    public function setPoints(Request $request, League $league): JsonResponse
    {
        try {
            $request->validate([
                'team_id' => 'required|exists:teams,id',
                'points'  => 'required|integer|min:0'
            ]);
            $this->leagueService->setTeamPoints($league, $request->team_id, $request->points);
            return response()->json(['message' => 'Points updated']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update points'], 500);
        }
    }
}
