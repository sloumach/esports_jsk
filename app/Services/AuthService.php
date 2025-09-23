<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Repositories\ActivityLogRepository;
use App\Notifications\VerifyEmailNotification;

class AuthService
{
    public function __construct(
        private UserRepository $userRepository,
        private RoleRepository $roleRepository,
        private ActivityLogRepository $logRepository
    ) {}

    public function register(array $data): User
    {
        $user = $this->userRepository->create($data);

        // Default role = user
        $role = $this->roleRepository->findByName('user');
        if ($role) {
            $this->roleRepository->assignRoleToUser($role, $user);
        }

        $this->logRepository->log([
            'user_id' => $user->id,
            'action' => 'user.register',
            'description' => 'New user registered',
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }

    public function login(array $credentials): ?string
    {
        if (!Auth::attempt($credentials)) {
            return null;
        }

        /** @var User $user */
        $user = Auth::user();
        $token = $user->createToken('auth_token')->plainTextToken;

        $this->logRepository->log([
            'user_id' => $user->id,
            'action' => 'user.login',
            'description' => 'User logged in',
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);

        return $token;
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();

        $this->logRepository->log([
            'user_id' => $user->id,
            'action' => 'user.logout',
            'description' => 'User logged out',
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
