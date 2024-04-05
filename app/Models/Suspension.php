<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Suspension extends Model
{
    use HasFactory;

    protected $fillable = [
        'report',
        'handler',
        'suspended',
        'note',
        'from',
        'to',
    ];
}
