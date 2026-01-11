<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\Resource;
use App\Services\AuditLogger;
use App\Services\AppNotifier;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances = Maintenance::query()->with('resource')->orderByDesc('start_at')->paginate(15);
        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        $resources = Resource::orderBy('name')->get();
        return view('admin.maintenance.create', compact('resources'));
    }

    public function store(Request $request, AuditLogger $logger, AppNotifier $notifier)
    {
        $data = $request->validate([
            'resource_id' => ['required', 'exists:resources,id'],
            'start_at' => ['required', 'date'],
            'end_at' => ['required', 'date', 'after:start_at'],
            'reason' => ['required', 'string', 'max:2000'],
        ]);

        $m = Maintenance::create([
            'resource_id' => $data['resource_id'],
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
            'reason' => $data['reason'],
            'created_by' => $request->user()->id,
        ]);

        $logger->log($request->user()->id, 'maintenance.create', Maintenance::class, $m->id, $data);

        // notify resource manager if exists
        $res = Resource::find($data['resource_id']);
        if ($res && $res->manager_id) {
            $notifier->notify((int)$res->manager_id, 'maintenance', 'Maintenance planifiée', "Une maintenance est planifiée pour {$res->name}.", [
                'resource_id' => $res->id,
                'maintenance_id' => $m->id,
            ]);
        }

        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance créée.');
    }

    public function destroy(Request $request, Maintenance $maintenance, AuditLogger $logger)
    {
        $id = $maintenance->id;
        $maintenance->delete();
        $logger->log($request->user()->id, 'maintenance.delete', Maintenance::class, $id, []);

        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance supprimée.');
    }
}
