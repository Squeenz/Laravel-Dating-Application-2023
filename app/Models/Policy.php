<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Casts\PurifyHtmlOnGet;

class Policy extends Model
{
    use HasFactory;

    protected $casts =
    [
        'content' => PurifyHtmlOnGet::class,
    ];

    protected $fillable =
    [
        'title',
        'content',
    ];
}
