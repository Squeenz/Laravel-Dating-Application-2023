<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferences extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'gender_preference',
        'age_range_preference',
        'location_preference',
        'relationship_type_preference',
        'interests_hobbies_preference',
        'personality_traits_preference',
    ];

    protected $casts = [
        'age_range_preference' => 'array',
        'location_preference' => 'array',
        'interests_hobbies_preference' => 'array',
        'personality_traits_preference' => 'array',
    ];
}
