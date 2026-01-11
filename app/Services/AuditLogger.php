<?php

namespace App\Services;

use App\Models\ActionLog;

class AuditLogger
{
    public function log(int $actorId, string $action, string $targetType, int $targetId, array $meta = []): void
    {
        ActionLog::create([
            'actor_id' => $actorId,
            'action' => $action,
            'target_type' => $targetType,
            'target_id' => $targetId,
            'meta' => $meta,
        ]);
    }
}
