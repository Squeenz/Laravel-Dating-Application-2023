<?php

namespace App\Http\Controllers;

use App\Models\ChatRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class ChatRoomController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('update', ChatRoomController::class);

        $validated = $request->validate([
            'user1_id' => 'required|integer',
            'user2_id' => 'required|integer',
        ]);

        $user1 = $validated['user1_id'];
        $user2 = $validated['user2_id'];

        DB::transaction(function () use ($user1, $user2){
            $existingRecord = ChatRoom::where('user1_id', $user1)
            ->where('user2_id', $user2)
            ->lockForUpdate()
            ->first();

            if (!$existingRecord)
            {
                ChatRoom::create([
                    'name' => $validated['name'] = Str::random(20),
                    'user1_id' => $user1,
                    'user2_id' => $user2,
                ]);
            }
        });
    }
}
