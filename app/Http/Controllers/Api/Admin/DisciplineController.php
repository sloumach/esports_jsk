<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DisciplineRequest;
use App\Http\Resources\DisciplineResource;
use App\Models\Discipline;
use App\Services\ManagerService\DisciplineService;
use Illuminate\Http\JsonResponse;
use Throwable;

class DisciplineController extends Controller
{
    public function __construct(
        private DisciplineService $disciplineService
    ) {}

    public function index(): JsonResponse
    {
        try {
            return response()->json(
                DisciplineResource::collection($this->disciplineService->list())
            );
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch disciplines'], 500);
        }
    }

    public function store(DisciplineRequest $request): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('disciplines', 'public');
                $data['logo'] = $path;
            }

            $discipline = $this->disciplineService->create($data);
            return response()->json(new DisciplineResource($discipline), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create discipline'], 500);
        }
    }

    public function show(Discipline $discipline): JsonResponse
    {
        try {
            return response()->json(new DisciplineResource($discipline));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Discipline not found'], 404);
        }
    }

    public function update(DisciplineRequest $request, Discipline $discipline): JsonResponse
    {
        try {
            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('disciplines', 'public');
                $data['logo'] = $path;
            }

            $updated = $this->disciplineService->update($discipline, $data);
            return response()->json(new DisciplineResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update discipline'], 500);
        }
    }


    public function destroy(Discipline $discipline): JsonResponse
    {
        try {
            $this->disciplineService->delete($discipline);
            return response()->json(['message' => 'Discipline deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete discipline'], 500);
        }
    }
}
