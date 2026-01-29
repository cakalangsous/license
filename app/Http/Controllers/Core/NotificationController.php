<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Response;

class NotificationController extends Controller
{
    public function index(): Response
    {
        $notifications = auth()->user()->notifications()->paginate(20);

        return inertia('Core/Notifications/Index', [
            'notifications' => $notifications,
        ]);
    }

    public function loadMore(Request $request)
    {
        $limit = $request->input('limit', 10);
        $notifications = auth()->user()->notifications()->limit($limit)->get();

        return response()->json([
            'notifications' => $notifications,
            'unread_count' => auth()->user()->unreadNotifications()->count(),
        ]);
    }

    public function markAsRead(string $id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->markAsRead();
        }

        return back();
    }

    public function markAllAsRead()
    {
        auth()->user()->unreadNotifications->markAsRead();

        return back()->with(['success' => true, 'message' => 'All notifications marked as read']);
    }

    public function destroy(string $id)
    {
        $notification = auth()->user()->notifications()->where('id', $id)->first();

        if ($notification) {
            $notification->delete();
        }

        return back()->with(['success' => true, 'message' => 'Notification removed']);
    }
}
