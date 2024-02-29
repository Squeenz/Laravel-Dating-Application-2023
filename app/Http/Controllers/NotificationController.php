<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Inertia\Response;
use Inertia\Inertia;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $notifications = Auth::user()->notifications()->with('otherUser')->orderBy('created_at', 'desc')->get();

        return Inertia::render('Notifications/Notifications', [
            'notifications' => $notifications,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required',
            'other_user_id' => 'required',
            'type' => 'required',
            'read' => 'required',
        ]);

        Notification::create($validated);
    }

     /**
     * Set notifications to read
     */
    public function readNotifications(Request $request)
    {
        $user = Auth::user();

        $notifications = $user->notifications;

        foreach ($notifications as $notification)
        {
            $notification->update(['read' => 1]);
            $notification->update(['updated_at' => now()]);
        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyAll(Request $request)
    {
        $user = Auth::user();

        $notifications = $user->notifications;

        foreach ($notifications as $notification)
        {
            $notification->delete();
        };
    }
}
