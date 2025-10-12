<?php

namespace App\Http\Controllers\Api\Admin;

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

            return response()->json(
                DisciplineResource::collection($this->disciplineService->list())
            );

    }

    public function store(DisciplineRequest $request): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('disciplines', 'public');
                $data['logo'] = $path;
            }

            $discipline = $this->disciplineService->create($data);
            return response()->json(new DisciplineResource($discipline), 201);

    }

    public function show(Discipline $discipline): JsonResponse
    {

            return response()->json(new DisciplineResource($discipline));

    }

    public function update(DisciplineRequest $request, Discipline $discipline): JsonResponse
    {

            $data = $request->validated();

            if ($request->hasFile('logo')) {
                $path = $request->file('logo')->store('disciplines', 'public');
                $data['logo'] = $path;
            }

            $updated = $this->disciplineService->update($discipline, $data);
            return response()->json(new DisciplineResource($updated));

    }


    public function destroy(Discipline $discipline): JsonResponse
    {

            $this->disciplineService->delete($discipline);
            return response()->json(['message' => 'Discipline deleted successfully']);

    }
}
