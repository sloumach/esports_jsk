<?php

namespace App\Repositories;

use App\Models\ActivityLog;

class ActivityLogRepository
{
    public function log(array $data): ActivityLog
    {
        return ActivityLog::create($data);
    }
}
