<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupportTicketChatRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'handler',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function supportTicket(): BelongsTo
    {
        return $this->belongsTo(SupportTicket::class);
    }

    public function supportChatMessages(): HasMany
    {
        return $this->hasMany(SupportTicketChatRoomMessages::class, 'support_chat_room');
    }
}
