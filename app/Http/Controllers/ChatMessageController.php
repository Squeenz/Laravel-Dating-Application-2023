<?php

namespace App\Http\Controllers;

use App\Models\ChatMessage;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Crypt;

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

        $room = $chatMessage->chatRoom;

        return redirect(route('chat.app.show', $room->name));
    }
}