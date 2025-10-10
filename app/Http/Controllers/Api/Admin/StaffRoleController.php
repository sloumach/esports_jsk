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
        try {
            return response()->json(
                StaffRoleResource::collection($this->staffRoleService->list())
            );
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to fetch staff roles'], 500);
        }
    }

    public function store(StaffRoleRequest $request): JsonResponse
    {
        try {
            $role = $this->staffRoleService->create($request->validated());
            return response()->json(new StaffRoleResource($role), 201);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to create staff role'], 500);
        }
    }

    public function update(StaffRoleRequest $request, StaffRole $staffRole): JsonResponse
    {
        try {
            $updated = $this->staffRoleService->update($staffRole, $request->validated());
            return response()->json(new StaffRoleResource($updated));
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to update staff role'], 500);
        }
    }

    public function destroy(StaffRole $staffRole): JsonResponse
    {
        try {
            $this->staffRoleService->delete($staffRole);
            return response()->json(['message' => 'Staff role deleted successfully']);
        } catch (Throwable $e) {
            return response()->json(['error' => 'Unable to delete staff role'], 500);
        }
    }
}
