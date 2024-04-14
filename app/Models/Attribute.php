<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Rules\CheckArrayString;

class Attribute extends Model
{
    use HasFactory;

    // Define constant arrays for attribute options
    public const SMOKING_STATUSES = [
        'Non-smoker',
        'Occasional smoker',
        'Regular smoker'
    ];

    public const DRINKING_HABITS = [
        'Non-drinker',
        'Social drinker',
        'Heavy drinker'
    ];

    public const BODY_TYPES = [
        'Slim',
        'Athletic',
        'Average',
        'Curvy',
        'Muscular',
        'Overweight'
    ];

    public const EXERCISE_FREQUENCIES = [
        'Rarely',
        'Occasionally',
        'Regularly'
    ];

    public const PETS_OPTIONS = [
        'Dog',
        'Cat',
        'Other',
        'None'
    ];

    public const DIETARY_OPTIONS = [
        'Vegetarian',
        'Vegan',
        'Gluten-free',
        'Pescatarian',
        'Omnivore'
    ];

    public const LANGUAGE_OPTIONS = [
        'English',
        'Spanish',
        'French',
        'German',
        'Mandarin',
        'Arabic',
        'Russian',
        'Japanese',
    ];

    public const MUSIC_GENRES = [
        'Pop',
        'Rock',
        'Hip-hop',
        'Country',
        'Electronic',
        'Jazz',
        'Classical',
        'Indie',
        'Folk',
    ];

    public const MOVIES_GENRES = [
        'Action',
        'Comedy',
        'Drama',
        'Horror',
        'Romance',
        'Thriller',
        'Sci-fi',
        'Fantasy',
        'Documentary',
    ];

    public const BOOKS_GENRES = [
        'Fiction',
        'Non-fiction',
        'Mystery',
        'Thriller',
        'Romance',
        'Sci-fi',
        'Fantasy',
        'Biography',
        'Self-help',
        'Other'
    ];

    public const TRAVEL_OPTIONS = [
        'Beach',
        'Mountains',
        'City',
        'Countryside',
        'Cultural',
        'Adventure',
        'Relaxation',
        'Solo',
        'Group',
        'Luxury',
        'Budget'
    ];

    public const HAS_CHILDREN_OPTIONS = [
        'Yes',
        'No'
    ];

    public const WANTS_CHILDREN_OPTIONS = [
        'Yes',
        'No',
        'Undecided'
    ];

    public const EDUCATION_LEVELS = [
        'High school',
        'Associate degree',
        'Bachelor\'s degree',
        'Master\'s degree',
        'Doctoral degree',
        'Other'
    ];

    public const OCCUPATION_OPTIONS = [
        'Student',
        'Professional',
        'Manager',
        'Entrepreneur',
        'Artist',
        'Homemaker',
        'Retired',
    ];

    public const HEIGHT_OPTIONS = [
        'Short',
        'Average',
        'Tall'
    ];

    public const BODY_TYPE_OPTIONS = [
        'Slim',
        'Athletic',
        'Average',
        'Curvy',
        'Muscular',
        'Overweight'
    ];

    public const ETHNICITY_OPTIONS = [
        'Caucasian',
        'African American',
        'Hispanic',
        'Asian',
        'Middle Eastern',
        'Native American',
        'Other'
    ];

    public const RELIGION_OPTIONS = [
        'Christianity',
        'Islam',
        'Judaism',
        'Hinduism',
        'Buddhism',
        'Sikhism',
        'Other',
        'None'
    ];

    public const HOBBIES_OPTIONS = [
        'Reading',
        'Sports',
        'Cooking',
        'Arts and crafts',
        'Gaming',
        'Photography',
        'Gardening',
        'Hiking and nature',
        'Camping and stargazing',
        'Rock climbing',
        'Experimental cooking',
        'Foodie adventures',
        'Farmers markets',
        'Yoga and meditation',
        'Running and marathons',
        'CrossFit',
        'Art galleries and museums',
        'Theater and musicals',
        'Painting and pottery',
        'Travel exploration',
        'Backpacking adventures',
        'Road trips',
        'Book club enthusiast',
        'Literary events',
        'Independent bookstores',
        'Concerts and festivals',
        'Learning music instruments',
        'Vinyl records',
        'Board games',
        'Video game marathons',
        'Gaming communities',
        'Community service',
        'Animal shelter volunteer',
        'Fundraising for causes',
        'Online courses',
        'Language exchange',
        'Science and tech events',
        'Live sports',
        'Recreational sports',
        'Fantasy sports leagues',
        'Sustainable living',
        'Upcycling and DIY'
    ];

    protected $fillable = [
        'user_id',
        'smoking_status',
        'has_children',
        'wants_children',
        'education_level',
        'occupation',
        'height',
        'body_type',
        'ethnicity',
        'religion',
        'hobbies',
        'drinking_habits',
        'dietary',
        'exercise_frequency',
        'languages_spoken',
        'pets',
        'music_genres',
        'movies_genres',
        'books_genres',
        'travel',
    ];

    // Validation rules for attribute values
    public static function rules()
    {
        return [
            'smoking_status' => 'nullable|string|in:' . implode(',', self::SMOKING_STATUSES),
            'drinking_habits' => 'nullable|string|in:' . implode(',', self::DRINKING_HABITS),
            'has_children' => 'nullable|string|in:' . implode(',', self::HAS_CHILDREN_OPTIONS),
            'wants_children' => 'nullable|string|in:' . implode(',', self::WANTS_CHILDREN_OPTIONS),
            'education_level' => ['nullable', 'string', new CheckArrayString(self::EDUCATION_LEVELS)],
            'occupation' => ['nullable', 'string', new CheckArrayString(self::OCCUPATION_OPTIONS)],
            'height' => 'nullable|string|in:' . implode(',', self::HEIGHT_OPTIONS),
            'body_type' => 'nullable|string|in:' . implode(',', self::BODY_TYPE_OPTIONS),
            'ethnicity' => 'nullable|string|in:' . implode(',', self::ETHNICITY_OPTIONS),
            'religion' => 'nullable|string|in:' . implode(',', self::RELIGION_OPTIONS),
            'dietary' => 'nullable|string|in:' . implode(',', self::DIETARY_OPTIONS),
            'exercise_frequency' => 'nullable|string|in:' . implode(',', self::EXERCISE_FREQUENCIES),
            'hobbies' => [ 'nullable', 'string', new CheckArrayString(self::HOBBIES_OPTIONS)],
            'languages_spoken' => [ 'nullable', 'string', new CheckArrayString(self::LANGUAGE_OPTIONS)],
            'pets' => [ 'nullable', 'string', new CheckArrayString(self::PETS_OPTIONS)],
            'music_genres' => [ 'nullable', 'string', new CheckArrayString(self::MUSIC_GENRES)],
            'movies_genres' => [ 'nullable', 'string', new CheckArrayString(self::MOVIES_GENRES)],
            'books_genres' => [ 'nullable', 'string', new CheckArrayString(self::BOOKS_GENRES)],
            'travel' => [ 'nullable', 'string', new CheckArrayString(self::TRAVEL_OPTIONS)]
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
                'options' => self::BODY_TYPES
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
            'music_genres' => [
                'multiple' => true,
                'options' => self::MUSIC_GENRES
            ],
            'movies_genres' => [
                'multiple' => true,
                'options' => self::MOVIES_GENRES
            ],
            'books_genres' => [
                'multiple' => true,
                'options' => self::BOOKS_GENRES
            ],
            'travel' => [
                'multiple' => true,
                'options' => self::TRAVEL_OPTIONS
            ],
            'has_children' => [
                'multiple' => false,
                'options' => self::HAS_CHILDREN_OPTIONS
            ],
            'wants_children' => [
                'multiple' => false,
                'options' => self::WANTS_CHILDREN_OPTIONS
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
            'hobbies' => [
                'multiple' => true,
                'options' => self::HOBBIES_OPTIONS
            ],
        ];
    }

    /**
     * Get a specific attribute options in JSON format.
     *
     * @param string $attribute
     * @return array|null
     */
    public static function getOptions(string $attribute): ?array
    {
        $options = [
            'smoking' => self::SMOKING_STATUSES,
            'drinking' => self::DRINKING_HABITS,
            'body_types' => self::BODY_TYPES,
            'exercise_frequencies' => self::EXERCISE_FREQUENCIES,
            'pets' => self::PETS_OPTIONS,
            'dietary' => self::DIETARY_OPTIONS,
            'languages' => self::LANGUAGE_OPTIONS,
            'music_genres' => self::MUSIC_GENRES,
            'movies_genres' => self::MOVIES_GENRES,
            'books_genres' => self::BOOKS_GENRES,
            'travel_options' => self::TRAVEL_OPTIONS,
            'has_children' => self::HAS_CHILDREN_OPTIONS,
            'wants_children' => self::WANTS_CHILDREN_OPTIONS,
            'education_levels' => self::EDUCATION_LEVELS,
            'occupations' => self::OCCUPATION_OPTIONS,
            'height_options' => self::HEIGHT_OPTIONS,
            'ethnicity_options' => self::ETHNICITY_OPTIONS,
            'religion_options' => self::RELIGION_OPTIONS,
            'hobbies_options' => self::HOBBIES_OPTIONS,
        ];

        return $options[$attribute] ?? null;
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
