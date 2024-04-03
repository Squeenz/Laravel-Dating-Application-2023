<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DisplayBlock extends Model
{
    use HasFactory;

    protected $fillable = [
        'layout_id',
        'type',
    ];

    public function layout(): BelongsTo
    {
        return $this->belongsTo(Layout::class, 'layout_id');
    }

    public function contents(): HasMany
    {
        return $this->hasMany(Content::class, 'display_block_id');
    }
}
