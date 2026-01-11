<?php

namespace App\Services;

use App\Models\AppNotification;

class AppNotifier
{
    public function notify(int $userId, string $type, string $title, string $body, array $meta = []): void
    {
        AppNotification::create([
            'user_id' => $userId,
            'type' => $type,
            'title' => $title,
            'body' => $body,
            'meta' => $meta,
        ]);
    }
}
