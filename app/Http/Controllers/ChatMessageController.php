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

        $user1 = $validated['user_id'];
        $user2 = ($user1 === $chatMessage->chatRoom->user1->id) ? $chatMessage->chatRoom->user2->id : $chatMessage->chatRoom->user1->id;

        event(new UserNotification($user1, $user2, "Message"));

        return redirect(route('chat.app.show', $room->name));
    }
}
