<?php

namespace App\Policies;

use App\Models\User;
use App\Models\SupportTicketChatRoom;

class SupportTicketChatRoomPolicy
{
    /**
     * Create a new policy instance.
     */
    public function canSendMessage(User $user, SupportTicketChatRoom $supportTicketChatRoom)
    {
        return $user->hasPermissionTo('send ticket message') && $user->id === $supportTicketChatRoom->user || $user->id === $supportTicketChatRoom->handler || $user->hasRole('admin');
    }
}
