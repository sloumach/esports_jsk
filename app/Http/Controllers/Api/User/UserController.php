<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService
    ) {}

    /**
     * Get user profile.
     */
    public function show(string $id): JsonResponse
    {
        $user = $this->userService->getUser($id);
        return response()->json(new UserResource($user));
    }

    /**
     * Update user profile.
     */
    public function update(UpdateUserRequest $request, User $user): JsonResponse
    {
        $updated = $this->userService->updateUser($user, $request->validated());
        return response()->json(new UserResource($updated));
    }

    /**
     * Delete user account.
     */
    public function destroy(User $user): JsonResponse
    {
        $this->userService->deleteUser($user);
        return response()->json(['message' => 'User deleted successfully']);
    }
}
