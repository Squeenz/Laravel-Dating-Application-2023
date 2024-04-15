<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Preferences extends Model
{
    use HasFactory;

    private const GENDERS = [
        'Male',
        'Female',
        'Other',
        'Does not matter'
    ];

    private const SMOKING_STATUSES = [
        'Non-smoker',
        'Occasional smoker',
        'Regular smoker',
        'Does not matter',
    ];

    private const DRINKING_HABITS = [
        'Non-drinker',
        'Social drinker',
        'Heavy drinker',
        'Does not matter',
    ];

    private const HAS_CHILDREN = [
        'Yes',
        'No',
        'Does not matter',
    ];

    private const WANT_CHILDREN = [
        'Yes',
        'No',
        'Does not matter',
    ];

    private const EDUCATION_LEVELS = [
        'High school',
        'Associate degree',
        'Bachelor\'s degree',
        'Master\'s degree',
        'Doctoral degree',
        'Does not matter',
    ];

    private const OCCUPATION_OPTIONS = [
        'Student',
        'Professional',
        'Manager',
        'Entrepreneur',
        'Artist',
        'Homemaker',
        'Retired',
        'Does not matter',
    ];

    private const HEIGHT_OPTIONS = [
        'Short',
        'Average',
        'Tall',
        'Does not matter',
    ];

    private const BODY_TYPE_OPTIONS = [
        'Slim',
        'Athletic',
        'Average',
        'Curvy',
        'Muscular',
        'Overweight',
        'Does not matter',
    ];

    private const ETHNICITY_OPTIONS = [
        'Caucasian',
        'African American',
        'Hispanic',
        'Asian',
        'Middle Eastern',
        'Native American',
        'Other',
        'Does not matter',
    ];

    private const RELIGION_OPTIONS = [
        'Christianity',
        'Islam',
        'Judaism',
        'Hinduism',
        'Buddhism',
        'Sikhism',
        'Other',
        'None',
        'Does not matter',
    ];

    private const DIETARY_OPTIONS = [
        'Vegetarian',
        'Vegan',
        'Gluten-free',
        'Pescatarian',
        'Omnivore',
        'Does not matter',
    ];

    private const EXERCISE_FREQUENCIES = [
        'Rarely',
        'Occasionally',
        'Regularly',
        'Does not matter',
    ];

    private const LANGUAGE_OPTIONS = [
        'English',
        'Spanish',
        'French',
        'German',
        'Mandarin',
        'Arabic',
        'Russian',
        'Japanese',
        'Does not matter',
    ];

    private const PETS_OPTIONS = [
        'Dog',
        'Cat',
        'Other',
        'None',
        'Does not matter',
    ];

    protected $fillable = [
        'user_id',
        'gender',
        'age_range',
        'smoking_status',
        'drinking_habits',
        'has_children',
        'wants_children',
        'education_level',
        'occupation',
        'height',
        'body_type',
        'ethnicity',
        'religion',
        'dietary',
        'exercise_frequency',
        'languages_spoken',
        'pets',
    ];


    // Validation rules for attribute values
    public static function rules()
    {
        return [
            'gender' => 'required|string|in:' . implode(',', self::GENDERS),
            'age_range' => 'required|string',
            'smoking_status' => 'required|string|in:' . implode(',', self::SMOKING_STATUSES),
            'drinking_habits' => 'required|string|in:' . implode(',', self::DRINKING_HABITS),
            'has_children' => 'required|string|in:' . implode(',', self::HAS_CHILDREN),
            'wants_children' => 'required|string|in:' . implode(',', self::WANT_CHILDREN),
            'education_level' => 'required|string|in:' . implode(',', self::EDUCATION_LEVELS),
            'occupation' => 'required|string|in:' . implode(',', self::OCCUPATION_OPTIONS),
            'height' => 'required|string|in:' . implode(',', self::HEIGHT_OPTIONS),
            'body_type' => 'required|string|in:' . implode(',', self::BODY_TYPE_OPTIONS),
            'ethnicity' => 'required|string|in:' . implode(',', self::ETHNICITY_OPTIONS),
            'religion' => 'required|string|in:' . implode(',', self::RELIGION_OPTIONS),
            'dietary' => 'required|string|in:' . implode(',', self::DIETARY_OPTIONS),
            'exercise_frequency' => 'required|string|in:' . implode(',', self::EXERCISE_FREQUENCIES),
            'languages_spoken' => 'required|string|in:' . implode(',', self::LANGUAGE_OPTIONS),
            'pets' => 'required|string|in:' . implode(',', self::PETS_OPTIONS),
        ];
    }

     /**
     * Get all attribute options in JSON format.
     *
     * @return array
     */
    public static function getAllOptions(): array
    {
        return [
            'gender' => [
                'multiple' => false,
                'options' => self::GENDERS
            ],
            'smoking_status' => [
                'multiple' => false,
                'options' => self::SMOKING_STATUSES
            ],
            'drinking_habits' => [
                'multiple' => false,
                'options' => self::DRINKING_HABITS
            ],
            'body_type' => [
                'multiple' => false,
                'options' => self::BODY_TYPE_OPTIONS
            ],
            'exercise_frequency' => [
                'multiple' => false,
                'options' => self::EXERCISE_FREQUENCIES
            ],
            'pets' => [
                'multiple' => true,
                'options' => self::PETS_OPTIONS
            ],
            'dietary' => [
                'multiple' => false,
                'options' => self::DIETARY_OPTIONS
            ],
            'languages_spoken' => [
                'multiple' => true,
                'options' => self::LANGUAGE_OPTIONS
            ],
            'has_children' => [
                'multiple' => false,
                'options' => self::HAS_CHILDREN
            ],
            'wants_children' => [
                'multiple' => false,
                'options' => self::WANT_CHILDREN
            ],
            'education_level' => [
                'multiple' => true,
                'options' => self::EDUCATION_LEVELS
            ],
            'occupation' => [
                'multiple' => true,
                'options' => self::OCCUPATION_OPTIONS
            ],
            'height' => [
                'multiple' => false,
                'options' => self::HEIGHT_OPTIONS
            ],
            'ethnicity' => [
                'multiple' => false,
                'options' => self::ETHNICITY_OPTIONS
            ],
            'religion' => [
                'multiple' => false,
                'options' => self::RELIGION_OPTIONS
            ],
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
