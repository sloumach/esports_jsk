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

            return response()->json(LeagueResource::collection($this->leagueService->list()));

    }

    public function store(LeagueRequest $request): JsonResponse
    {

            $league = $this->leagueService->create($request->validated());
            return response()->json(new LeagueResource($league), 201);

    }

    public function show(League $league): JsonResponse
    {

            return response()->json(new LeagueResource($league->load(['discipline', 'teams'])));

    }

    public function update(LeagueRequest $request, League $league): JsonResponse
    {

            $updated = $this->leagueService->update($league, $request->validated());
            return response()->json(new LeagueResource($updated));

    }

    public function destroy(League $league): JsonResponse
    {

            $this->leagueService->delete($league);
            return response()->json(['message' => 'League deleted successfully']);

    }

    /* ===== Custom endpoints for teams in a league ===== */

    public function addTeam(Request $request, League $league): JsonResponse
    {

            $request->validate(['team_id' => 'required|exists:teams,id']);
            $this->leagueService->addTeam($league, $request->team_id);
            return response()->json(['message' => 'Team added to league']);

    }

    public function removeTeam(Request $request, League $league): JsonResponse
    {

            $request->validate(['team_id' => 'required|exists:teams,id']);
            $this->leagueService->removeTeam($league, $request->team_id);
            return response()->json(['message' => 'Team removed from league']);

    }

    public function setPoints(Request $request, League $league): JsonResponse
    {

            $request->validate([
                'team_id' => 'required|exists:teams,id',
                'points'  => 'required|integer|min:0'
            ]);
            $this->leagueService->setTeamPoints($league, $request->team_id, $request->points);
            return response()->json(['message' => 'Points updated']);

    }
}
