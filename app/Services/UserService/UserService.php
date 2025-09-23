<?php

namespace App\Services\UserService;

use App\Models\User;
use App\Repositories\UserRepository;
use App\Repositories\ActivityLogRepository;
use Illuminate\Support\Facades\Request;

class UserService
{
    public function __construct(
        private UserRepository $userRepository,
        private ActivityLogRepository $logRepository
    ) {}

    public function getUser(string $id): ?User
    {
        return $this->userRepository->findById($id);
    }

    public function updateUser(User $user, array $data): User
    {
        $updated = $this->userRepository->update($user, $data);

        $this->logRepository->log([
            'user_id' => $user->id,
            'action' => 'user.update',
            'description' => 'User updated profile',
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);

        return $updated;
    }

    public function deleteUser(User $user): void
    {
        $this->userRepository->delete($user);

        $this->logRepository->log([
            'user_id' => $user->id,
            'action' => 'user.delete',
            'description' => 'User account deleted',
            'ip_address' => Request::ip(),
            'user_agent' => Request::header('User-Agent'),
        ]);
    }
}
