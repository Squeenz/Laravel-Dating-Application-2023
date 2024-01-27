<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\Inertia;

use function Laravel\Prompts\error;

class ChatApplication extends Controller
{
    public function index()
    {
        $userID = Auth::user()->id;

        $chatRooms = ChatRoom::with(['user1', 'user2'])
        ->where(function ($query) use ($userID) {
            $query->where('user1_id', '!=', $userID)
                ->orWhere('user2_id', '!=', $userID);
        })
        ->get();

        return Inertia::render('Messenger/App', [
            'chatRooms' => $chatRooms,
        ]);
    }

    public function show(ChatRoom $chatRoom, $roomName)
    {
        $userID = Auth::user()->id;

        $chatRoom = ChatRoom::with(['user1', 'user2', 'chatMessages'])
        ->where('name', $roomName)
        ->where('user1_id', $userID)
        ->orWhere('user2_id', $userID)
        ->first();

        $chatRooms = ChatRoom::with(['user1', 'user2'])
        ->where(function ($query) use ($userID) {
            $query->where('user1_id', '!=', $userID)
                ->orWhere('user2_id', '!=', $userID);
        })
        ->get();


        if (!$chatRoom) {
            abort(404);
        }

        $chatMessages = $chatRoom->chatMessages;

        return Inertia::render('Messenger/App', [
            'roomID' => $chatRoom->id,
            'chatRooms' => $chatRooms,
            'chatMessages' => $chatMessages,
        ]);
    }
}
