<?php

namespace App\Services;

use App\Models\Maintenance;
use App\Models\Reservation;
use App\Models\ReservationItem;
use Carbon\Carbon;
use Illuminate\Support\Collection;

class ReservationAvailabilityService
{
    /**
     * Returns array of conflicts for the given resources/time range.
     * Conflicts include:
     * - overlapping approved/active reservations
     * - overlapping maintenance windows
     */
    public function conflicts(array $resourceIds, Carbon $startAt, Carbon $endAt): array
    {
        $conflicts = [];

        // Maintenance conflicts
        $maint = Maintenance::query()
            ->whereIn('resource_id', $resourceIds)
            ->where(function ($q) use ($startAt, $endAt) {
                $q->whereBetween('start_at', [$startAt, $endAt])
                  ->orWhereBetween('end_at', [$startAt, $endAt])
                  ->orWhere(function ($q2) use ($startAt, $endAt) {
                      $q2->where('start_at', '<=', $startAt)->where('end_at', '>=', $endAt);
                  });
            })->get();

        foreach ($maint as $m) {
            $conflicts[] = [
                'type' => 'maintenance',
                'resource_id' => $m->resource_id,
                'message' => 'Maintenance planifiée sur la période demandée.',
                'start_at' => $m->start_at,
                'end_at' => $m->end_at,
            ];
        }

        // Reservation conflicts (approved/active)
        $items = ReservationItem::query()
            ->whereIn('resource_id', $resourceIds)
            ->whereHas('reservation', function ($q) use ($startAt, $endAt) {
                $q->whereIn('status', [Reservation::STATUS_APPROVED, Reservation::STATUS_ACTIVE])
                  ->where(function ($q2) use ($startAt, $endAt) {
                      $q2->whereBetween('start_at', [$startAt, $endAt])
                         ->orWhereBetween('end_at', [$startAt, $endAt])
                         ->orWhere(function ($q3) use ($startAt, $endAt) {
                             $q3->where('start_at', '<=', $startAt)->where('end_at', '>=', $endAt);
                         });
                  });
            })
            ->with(['reservation:id,start_at,end_at,status', 'resource:id,name'])
            ->get();

        foreach ($items as $it) {
            $conflicts[] = [
                'type' => 'reservation',
                'resource_id' => $it->resource_id,
                'message' => 'Conflit avec une réservation existante.',
                'reservation_id' => $it->reservation_id,
                'start_at' => $it->reservation->start_at,
                'end_at' => $it->reservation->end_at,
                'resource_name' => $it->resource->name ?? null,
            ];
        }

        return $conflicts;
    }
}
