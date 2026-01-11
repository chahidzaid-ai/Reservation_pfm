<?php

namespace App\Policies;

use App\Models\Resource;
use App\Models\User;

class ResourcePolicy
{
    public function update(User $user, Resource $resource): bool
    {
        if ($user->role === User::ROLE_ADMIN) return true;
        if ($user->role === User::ROLE_MANAGER && (int)$resource->manager_id === (int)$user->id) return true;
        return false;
    }
}
