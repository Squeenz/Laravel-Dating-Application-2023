<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Events\UserNotification;
use App\Models\ChatMessage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class ChatMessageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'chat_room_id' => 'required|integer',
            'user_id' => 'required|integer',
            'content' => 'required',
        ]);

        // Encrypt the content before storing it in the database
        $validated['content'] = encrypt($validated['content']);

        $chatMessage = ChatMessage::create($validated);

        event(new NewMessage($chatMessage));

        $room = $chatMessage->chatRoom;

        $user1ID = $chatMessage->user_id;

        $user2Messages = ChatMessage::where('chat_room_id', $room->id)
            ->where('user_id', '!=', $user1ID)
            ->get();

        //causes and erro becaue at the start the user 2 message doesn't exist

        // Extract user IDs from $user2Messages
        $user2IDs = $user2Messages->pluck('user_id')->unique()->toArray();

        $user1 = User::find($user1ID);
        $user2 = User::whereIn('id', $user2IDs)->first();

        event(new UserNotification($user1, $user2, "Message"));

        return redirect(route('chat.app.show', $room->name));
    }
}
