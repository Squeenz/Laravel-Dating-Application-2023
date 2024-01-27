<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;

class ChatRoomController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user1_id' => 'required|integer',
            'user2_id' => 'required|integer',
        ]);

        $validated['name'] = Str::random(20);

        ChatRoom::create($validated);

        return redirect(route('chat.app'));
    }
}
