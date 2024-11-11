<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function markAsRead(Request $request)
    {
        $user = auth()->user();
        $user->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    public function index()
    {
        $user = Auth::user();
        $notifications = $user->notifications;
        \Log::info('Notifications: ', $notifications->toArray());
    
        return view('user.Notification', compact('notifications'));
    }
}


