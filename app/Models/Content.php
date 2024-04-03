<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Content extends Model
{
    use HasFactory;

    protected $fillable = [
        'display_block_id',
        'title',
        'desc',
    ];

    public function displayBlock(): BelongsTo
    {
        return $this->belongsTo(DisplayBlock::class, 'display_block_id');
    }
}
