<?php

namespace App\Http\Controllers;

use App\Models\Incident;
use App\Models\Resource;
use App\Models\Reservation;
use App\Services\AuditLogger;
use Illuminate\Http\Request;

class IncidentController extends Controller
{
    public function index(Request $request)
    {
        $q = Incident::query()->with(['resource', 'reservation', 'reporter'])->orderByDesc('created_at');

        // user sees their incidents; managers/admin see all
        if (!in_array($request->user()->role, ['manager', 'admin'], true)) {
            $q->where('reporter_id', $request->user()->id);
        }

        $incidents = $q->paginate(15)->withQueryString();
        return view('incidents.index', compact('incidents'));
    }

    public function create(Request $request)
    {
        $resources = Resource::orderBy('name')->get();
        $reservations = Reservation::query()->where('user_id', $request->user()->id)->orderByDesc('created_at')->limit(50)->get();
        return view('incidents.create', compact('resources', 'reservations'));
    }

    public function store(Request $request, AuditLogger $logger)
    {
        $data = $request->validate([
            'resource_id' => ['nullable', 'exists:resources,id'],
            'reservation_id' => ['nullable', 'exists:reservations,id'],
            'description' => ['required', 'string', 'max:4000'],
        ]);

        $incident = Incident::create([
            'reporter_id' => $request->user()->id,
            'resource_id' => $data['resource_id'] ?? null,
            'reservation_id' => $data['reservation_id'] ?? null,
            'status' => Incident::STATUS_OPEN,
            'description' => $data['description'],
        ]);

        $logger->log($request->user()->id, 'incident.create', Incident::class, $incident->id, $data);

        return redirect()->route('incidents.show', $incident)->with('success', 'Incident signalé.');
    }

    public function show(Request $request, Incident $incident)
    {
        // basic view authorization
        if (!in_array($request->user()->role, ['manager', 'admin'], true) && (int)$incident->reporter_id !== (int)$request->user()->id) {
            abort(403);
        }
        $incident->load(['resource', 'reservation', 'reporter', 'handler']);
        return view('incidents.show', compact('incident'));
    }
}
