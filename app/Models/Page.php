<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Page extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'page_name',
        'slug',
    ];

    public function layout(): HasOne
    {
        return $this->hasOne(Layout::class, 'page_id');
    }
}
