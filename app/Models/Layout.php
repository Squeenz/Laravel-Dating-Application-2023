<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Layout extends Model
{
    use HasFactory;

    protected $fillable = [
        'page_id',
    ];

    public function page(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'layout_id');
    }

    public function displayBlocks(): HasMany
    {
        return $this->hasMany(DisplayBlock::class, 'layout_id');
    }
}
