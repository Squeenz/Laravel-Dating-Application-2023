<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;
use Inertia\Response;
use Inertia\Inertia;

class ChatApplicationController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', ChatApplicationController::class);

        $userID = Auth::user()->id;

        $chatRooms = ChatRoom::with(['user1', 'user2'])
        ->where(function ($query) use ($userID) {
            $query->where('user1_id', $userID)
                ->orWhere('user2_id', $userID);
        })
        ->get();

        return Inertia::render('Messenger/App', [
            'chatRooms' => $chatRooms,
        ]);
    }

    public function show(ChatRoom $chatRoom, $roomName)
    {
        $this->authorize('view', ChatApplicationController::class);

        $userID = Auth::user()->id;

        $chatRoom = ChatRoom::with('chatMessages')
            ->where(function ($query) use ($roomName, $userID) {
                $query->where('name', $roomName)
                    ->where(function ($innerQuery) use ($userID) {
                        $innerQuery->where('user1_id', $userID)
                            ->orWhere('user2_id', $userID);
                    });
            })
            ->first();

        $chatRooms = ChatRoom::with(['user1', 'user2'])
            ->where(function ($query) use ($userID) {
                $query->where('user1_id', $userID)
                    ->orWhere('user2_id', $userID);
            })
            ->get();

        if (!$chatRoom) {
            abort(404);
        }

        // Decrypt each chat message content
        $chatMessages = $chatRoom->chatMessages->map(function ($message) {
            $message->content = decrypt($message->content);
            return $message;
        });

        $otherUser = $chatRoom->user1_id == $userID ? $chatRoom->user2 : $chatRoom->user1;

        return Inertia::render('Messenger/App', [
            'roomID' => $chatRoom->id,
            'chatRooms' => $chatRooms,
            'chatMessages' => $chatMessages,
            'otherUser' => $otherUser,
        ]);
    }

}
