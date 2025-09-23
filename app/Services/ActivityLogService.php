<?php

namespace App\Services;

use App\Repositories\ActivityLogRepository;

class ActivityLogService
{
    public function __construct(
        private ActivityLogRepository $logRepository
    ) {}

    public function log(array $data)
    {
        return $this->logRepository->log($data);
    }
}
