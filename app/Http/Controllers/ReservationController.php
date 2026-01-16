<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Resource;
use App\Models\ReservationItem;
use App\Services\ReservationAvailabilityService;
use App\Services\AuditLogger;
use App\Services\AppNotifier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate; // <--- 1. ADDED IMPORT

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $q = Reservation::query()->where('user_id', $request->user()->id)->with('items.resource');

        if ($request->filled('status')) {
            $q->where('status', $request->string('status'));
        }

        $reservations = $q->orderByDesc('created_at')->paginate(12)->withQueryString();
        return view('reservations.index', compact('reservations'));
    }

    public function create(Request $request)
    {
        // 2. FIXED: Changed 'state' to 'status' to match your database
        $resources = Resource::query()
            ->where('status', '!=', 'disabled') 
            ->with('category')
            ->orderBy('name')
            ->get();

        return view('reservations.create', compact('resources'));
    }

    public function store(
        Request $request,
        ReservationAvailabilityService $availability,
        AuditLogger $logger,
        AppNotifier $notifier
    ) {
        $data = $request->validate([
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'justification' => ['required', 'string', 'max:2000'],
            'resource_ids' => ['required', 'array', 'min:1'],
            'resource_ids.*' => ['integer', 'exists:resources,id'],
        ]);

        $startAt = Carbon::parse($data['start_at']);
        $endAt = Carbon::parse($data['end_at']);

        $conflicts = $availability->conflicts($data['resource_ids'], $startAt, $endAt);
        if (count($conflicts) > 0) {
            return back()->withInput()->with('error', 'Conflit détecté : veuillez choisir une autre période ou d’autres ressources.')
                ->with('conflicts', $conflicts);
        }

        $reservation = DB::transaction(function () use ($request, $data, $logger) {
            $reservation = Reservation::create([
                'user_id' => $request->user()->id,
                'status' => Reservation::STATUS_PENDING, // Ensure this constant exists in your Model, or use 'pending'
                'start_at' => $data['start_at'],
                'end_at' => $data['end_at'],
                'justification' => $data['justification'],
            ]);

            foreach ($data['resource_ids'] as $rid) {
                ReservationItem::create([
                    'reservation_id' => $reservation->id,
                    'resource_id' => $rid,
                ]);
            }

            $logger->log($request->user()->id, 'reservation.create', Reservation::class, $reservation->id, [
                'resource_ids' => $data['resource_ids'],
                'start_at' => $data['start_at'],
                'end_at' => $data['end_at'],
            ]);

            return $reservation;
        });

        // Notify managers
        $managerIds = Resource::query()->whereIn('id', $data['resource_ids'])->whereNotNull('manager_id')->pluck('manager_id')->unique();
        foreach ($managerIds as $mid) {
            $notifier->notify((int)$mid, 'reservation', 'Nouvelle demande de réservation', "Une nouvelle demande est en attente (ID #{$reservation->id}).", [
                'reservation_id' => $reservation->id,
            ]);
        }

        return redirect()->route('reservations.show', $reservation)->with('success', 'Demande envoyée.');
    }

    public function show(Request $request, Reservation $reservation)
    {
        // 3. FIXED: Used Gate facade instead of $this->authorize
        Gate::authorize('view', $reservation);
        
        $reservation->load('items.resource.category', 'user', 'decider');
        return view('reservations.show', compact('reservation'));
    }
}