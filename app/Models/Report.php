<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'suspect',
        'complainant',
        'violated_rule',
        'extra_information',
    ];

    public function suspect(): BelongsTo
    {
        return $this->belongsTo(User::class, 'suspect');
    }

    public function complainant(): BelongsTo
    {
        return $this->belongsTo(User::class, 'complainant');
    }
}
