<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Register a new user.
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = $this->authService->register($request->validated());
        return response()->json(new UserResource($user), 201);
    }

    /**
     * Login user and return token.
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->authService->login($request->only('email', 'password'));

        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        return response()->json([
            'token' => $token,
            'user'  => new UserResource(Auth::user()),
        ]);
    }

    /**
     * Logout user (invalidate token).
     */
    public function logout(): JsonResponse
    {
        $this->authService->logout(Auth::user());
        return response()->json(['message' => 'Logged out successfully']);
    }
}
