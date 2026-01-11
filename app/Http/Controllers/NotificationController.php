<?php

namespace App\Http\Controllers;

use App\Models\AppNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        $notifications = AppNotification::query()
            ->where('user_id', $request->user()->id)
            ->orderByDesc('created_at')
            ->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    public function markRead(Request $request, AppNotification $notification)
    {
        if ((int)$notification->user_id !== (int)$request->user()->id) {
            abort(403);
        }
        $notification->update(['read_at' => now()]);
        return back()->with('success', 'Notification marquée comme lue.');
    }
}
