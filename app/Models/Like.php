<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'liked_user_id',
        'is_like'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'liked_user_id');
    }
}
