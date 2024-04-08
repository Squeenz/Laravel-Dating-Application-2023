<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SupportTicket extends Model
{
    use HasFactory;

    protected $fillable = [
        'user',
        'reason',
        'support_chat_room',
        'status',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user');
    }

    public function supportChatRoom(): HasOne
    {
        return $this->hasOne(SupportTicketChatRoom::class, 'id', 'support_chat_room');
    }
}
