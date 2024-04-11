<?php

namespace App\Http\Controllers;

use App\Models\SupportTicketChatRoom;
use App\Models\SupportTicketChatRoomMessages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupportTicketChatRoomMessagesController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $supportChatRoom = SupportTicketChatRoom::findOrFail($request->support_chat_room);

        $this->authorize('canSendMessage', $supportChatRoom);

        $user = Auth::user();

        $validated = $request->validate([
            'content' => 'required',
            'support_chat_room' => 'required|integer',
        ]);

        $validated['content'] = encrypt($validated['content']);
        $validated['user'] = $user->id;

        SupportTicketChatRoomMessages::create($validated);
    }
}
