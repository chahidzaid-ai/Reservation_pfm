<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\ReservationItem;
use App\Models\Resource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        // Basic stats
        if ($user->role === User::ROLE_ADMIN) {
            $stats = [
                'resources_total' => Resource::count(),
                'resources_available' => Resource::where('state', Resource::STATE_AVAILABLE)->count(),
                'reservations_pending' => Reservation::where('status', Reservation::STATUS_PENDING)->count(),
                'reservations_approved' => Reservation::where('status', Reservation::STATUS_APPROVED)->count(),
            ];

            // Top categories usage (simple count of reservation_items)
            $top = DB::table('reservation_items')
                ->join('resources', 'resources.id', '=', 'reservation_items.resource_id')
                ->join('resource_categories', 'resource_categories.id', '=', 'resources.category_id')
                ->select('resource_categories.name as label', DB::raw('count(*) as value'))
                ->groupBy('resource_categories.name')
                ->orderByDesc('value')
                ->limit(6)
                ->get();

            return view('dashboards.admin', [
                'stats' => $stats,
                'chartData' => $top,
            ]);
        }

        if ($user->role === User::ROLE_MANAGER) {
            $managed = Resource::where('manager_id', $user->id)->pluck('id')->all();

            $stats = [
                'managed_resources' => count($managed),
                'pending_requests' => Reservation::where('status', Reservation::STATUS_PENDING)
                    ->whereHas('resources', fn($q) => $q->where('manager_id', $user->id))
                    ->count(),
                'approved_requests' => Reservation::where('status', Reservation::STATUS_APPROVED)
                    ->whereHas('resources', fn($q) => $q->where('manager_id', $user->id))
                    ->count(),
            ];

            $top = DB::table('reservation_items')
                ->join('resources', 'resources.id', '=', 'reservation_items.resource_id')
                ->select('resources.name as label', DB::raw('count(*) as value'))
                ->whereIn('resources.id', $managed ?: [0])
                ->groupBy('resources.name')
                ->orderByDesc('value')
                ->limit(6)
                ->get();

            return view('dashboards.manager', [
                'stats' => $stats,
                'chartData' => $top,
            ]);
        }

        // Standard user dashboard
        $stats = [
            'my_pending' => Reservation::where('user_id', $user->id)->where('status', Reservation::STATUS_PENDING)->count(),
            'my_approved' => Reservation::where('user_id', $user->id)->where('status', Reservation::STATUS_APPROVED)->count(),
            'my_finished' => Reservation::where('user_id', $user->id)->where('status', Reservation::STATUS_FINISHED)->count(),
        ];

        return view('dashboards.user', compact('stats'));
    }
}
