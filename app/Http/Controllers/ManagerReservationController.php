<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\User;
use App\Services\ReservationAvailabilityService;
use App\Services\AuditLogger;
use App\Services\AppNotifier;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ManagerReservationController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        $user = $request->user();

        $q = Reservation::query()
            ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_APPROVED])
            ->whereHas('resources', function ($qr) use ($user) {
                if ($user->role === User::ROLE_ADMIN) return;
                $qr->where('manager_id', $user->id);
            })
            ->with(['user', 'items.resource'])
            ->orderByDesc('created_at');

        $reservations = $q->paginate(12)->withQueryString();
        return view('manager.requests.index', compact('reservations'));
    }

    public function show(Request $request, Reservation $reservation)
    {
        $this->authorize('view', $reservation);
        $reservation->load('user', 'items.resource');
        return view('manager.requests.show', compact('reservation'));
    }

    public function approve(
        Request $request,
        Reservation $reservation,
        ReservationAvailabilityService $availability,
        AuditLogger $logger,
        AppNotifier $notifier
    ) {
        $this->authorize('view', $reservation);

        $data = $request->validate([
            'manager_note' => ['nullable', 'string', 'max:2000'],
        ]);

        // Re-check conflicts at approval time
        $resourceIds = $reservation->items()->pluck('resource_id')->all();
        $conflicts = $availability->conflicts($resourceIds, Carbon::parse($reservation->start_at), Carbon::parse($reservation->end_at));
        if (count($conflicts) > 0) {
            return back()->with('error', "Impossible d'approuver : conflit détecté.")->with('conflicts', $conflicts);
        }

        $reservation->update([
            'status' => Reservation::STATUS_APPROVED,
            'manager_note' => $data['manager_note'] ?? null,
            'decided_by' => $request->user()->id,
            'decided_at' => now(),
        ]);

        $logger->log($request->user()->id, 'reservation.approve', Reservation::class, $reservation->id, $data);

        $notifier->notify((int)$reservation->user_id, 'reservation', 'Réservation approuvée', "Votre demande #{$reservation->id} a été approuvée.", [
            'reservation_id' => $reservation->id,
        ]);

        return redirect()->route('manager.requests.show', $reservation)->with('success', 'Réservation approuvée.');
    }

    public function refuse(Request $request, Reservation $reservation, AuditLogger $logger, AppNotifier $notifier)
    {
        $this->authorize('view', $reservation);

        $data = $request->validate([
            'manager_note' => ['required', 'string', 'max:2000'],
        ]);

        $reservation->update([
            'status' => Reservation::STATUS_REFUSED,
            'manager_note' => $data['manager_note'],
            'decided_by' => $request->user()->id,
            'decided_at' => now(),
        ]);

        $logger->log($request->user()->id, 'reservation.refuse', Reservation::class, $reservation->id, $data);

        $notifier->notify((int)$reservation->user_id, 'reservation', 'Réservation refusée', "Votre demande #{$reservation->id} a été refusée.", [
            'reservation_id' => $reservation->id,
        ]);

        return redirect()->route('manager.requests.show', $reservation)->with('success', 'Réservation refusée.');
    }
}
