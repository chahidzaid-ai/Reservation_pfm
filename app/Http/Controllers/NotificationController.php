<?php

namespace App\Http\Controllers;

use App\Models\AppNotification; // <--- FIXED: Must match your Model name
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        // Get notifications for the CURRENT user
        $notifications = AppNotification::where('user_id', auth()->id())
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('notifications.index', compact('notifications'));
    }

    // Mark a specific notification as read
    public function markAsRead($id)
    {
        $notification = AppNotification::where('user_id', auth()->id())->findOrFail($id);
        
        $notification->update(['read_at' => now()]);

        return back()->with('success', 'Notification marquée comme lue.');
    }

    // Mark ALL as read
    public function markAllRead()
    {
        AppNotification::where('user_id', auth()->id())
            ->whereNull('read_at')
            ->update(['read_at' => now()]);

        return back()->with('success', 'Toutes les notifications sont marquées comme lues.');
    }
}