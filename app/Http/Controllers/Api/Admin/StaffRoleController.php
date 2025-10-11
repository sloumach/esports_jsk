<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StaffRoleRequest;
use App\Http\Resources\StaffRoleResource;
use App\Models\StaffRole;
use App\Services\ManagerService\StaffRoleService;
use Illuminate\Http\JsonResponse;
use Throwable;

class StaffRoleController extends Controller
{
    public function __construct(
        private StaffRoleService $staffRoleService
    ) {}

    public function index(): JsonResponse
    {

            return response()->json(
                StaffRoleResource::collection($this->staffRoleService->list())
            );

    }

    public function store(StaffRoleRequest $request): JsonResponse
    {

            $role = $this->staffRoleService->create($request->validated());
            return response()->json(new StaffRoleResource($role), 201);

    }

    public function update(StaffRoleRequest $request, StaffRole $staffRole): JsonResponse
    {

            $updated = $this->staffRoleService->update($staffRole, $request->validated());
            return response()->json(new StaffRoleResource($updated));

    }

    public function destroy(StaffRole $staffRole): JsonResponse
    {

            $this->staffRoleService->delete($staffRole);
            return response()->json(['message' => 'Staff role deleted successfully']);

    }
}
