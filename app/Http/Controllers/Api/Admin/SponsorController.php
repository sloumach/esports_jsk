<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SponsorRequest;
use App\Http\Resources\SponsorResource;
use App\Models\Sponsor;
use App\Services\ManagerService\SponsorService;
use Illuminate\Http\JsonResponse;
use Throwable;

class SponsorController extends Controller
{
    public function __construct(
        private SponsorService $sponsorService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(SponsorResource::collection($this->sponsorService->list()));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch sponsors'], 500);
        }
    }

    public function store(SponsorRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('sponsors', 'public');
            }

            $sponsor = $this->sponsorService->create($data);
            return response()->json(new SponsorResource($sponsor), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create sponsor'], 500);
        }
    }

    public function update(SponsorRequest $request, Sponsor $sponsor): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('sponsors', 'public');
            }

            $updated = $this->sponsorService->update($sponsor, $data);
            return response()->json(new SponsorResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update sponsor'], 500);
        }
    }

    public function destroy(Sponsor $sponsor): JsonResponse
    {
        try {
            $this->sponsorService->delete($sponsor);
            return response()->json(['message' => 'Sponsor deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete sponsor'], 500);
        }
    }
}
