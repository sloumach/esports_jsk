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

            return response()->json(SponsorResource::collection($this->sponsorService->list()));

    }

    public function store(SponsorRequest $request): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('sponsors', 'public');
            }

            $sponsor = $this->sponsorService->create($data);
            return response()->json(new SponsorResource($sponsor), 201);

    }

    public function update(SponsorRequest $request, Sponsor $sponsor): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $data['logo'] = $request->file('logo')->store('sponsors', 'public');
            }

            $updated = $this->sponsorService->update($sponsor, $data);
            return response()->json(new SponsorResource($updated));

    }

    public function destroy(Sponsor $sponsor): JsonResponse
    {

            $this->sponsorService->delete($sponsor);
            return response()->json(['message' => 'Sponsor deleted successfully']);

    }
}
