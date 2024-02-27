<?php

use App\Models\ChatRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Broadcast;

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('matches', function(){
    return Auth::check();
});

Broadcast::channel('chatRooms', function(){
    return Auth::check();
});

Broadcast::channel('chat.{chatRoomName}', function($user, $chatRoomName){
    $chatRoom = ChatRoom::where('name', $chatRoomName)->first();
    return $chatRoom && ($user->id === $chatRoom->user1_id || $user->id === $chatRoom->user2_id);
});

Broadcast::channel('notification', function(){
    return Auth::check();
});
