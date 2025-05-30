<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        return view('notifications.index', [
            'notifications' => Auth::user()->notifications()->paginate(10)
        ]);
    }

    public function markAsRead($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return back()->with('status', 'Notification marked as read');
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        
        return back()->with('status', 'All notifications marked as read');
    }
}