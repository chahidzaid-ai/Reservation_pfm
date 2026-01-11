<?php

namespace App\Policies;

use App\Models\Reservation;
use App\Models\User;

class ReservationPolicy
{
    public function view(User $user, Reservation $reservation): bool
    {
        if ($user->role === User::ROLE_ADMIN) return true;
        if ((int)$reservation->user_id === (int)$user->id) return true;
        // managers can view reservations that include their resources
        if ($user->role === User::ROLE_MANAGER) {
            return $reservation->resources()->where('manager_id', $user->id)->exists();
        }
        return false;
    }
}
