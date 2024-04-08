<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportTicketChatRoomMessages extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'content',
        'support_chat_room'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function supportChatRoom(): BelongsTo
    {
        return $this->belongsTo(SupportTicketChatRoom::class, 'support_chat_room');
    }
}
