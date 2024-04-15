<?php

namespace App\Http\Controllers;

use App\Events\CreateChatRoom;
use App\Models\Matching;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\UserNotification;
use App\Models\Like;
use DateTime;
use Inertia\Inertia;
use Inertia\Response;

class MatchingController extends Controller
{
    public function index(): Response
    {
        $this->authorize('viewAny', MatchingController::class);

        $user = User::find(Auth::user()->id);

        $matches = Matching::where('user1_id', $user->id)
            ->orWhere('user2_id', $user->id)
            ->get();

        // Initialize an array to store other users
        $otherUsers = [];

        // Iterate through matches to find the other user for each match
        foreach ($matches as $match) {
            if ($match->user1_id == $user->id) {
                $otherUserId = $match->user2_id;
            } else {
                $otherUserId = $match->user1_id;
            }

            // Fetch the other user based on 'user2_id' and add to the array
            $otherUsers[] = User::find($otherUserId);
        }

        return Inertia::render('Matches/Matches', [
            'users' => $otherUsers,
        ]);
    }

    private function calculateAge(User $user)
    {
        $dob = new DateTime($user->dob);
        $currentDate = new DateTime();
        $age = $currentDate->diff($dob)->y;

        return $age;
    }

    private function getAgeRangeValues(User $user)
    {
        $data = $user->preferences()->get()->toArray();

        $ageData = [];

        foreach ($data as $item)
        {
            foreach ($item as $columnName => $value)
            {
                if ($columnName === 'age_range')
                {
                    $range = explode(',', $value);

                    $ageData = [
                        'min' => $range[0],
                        'max' => $range[1],
                    ];
                }
            }
        }

        return $ageData;
    }

    private function getIndividualValuesFromList(User $user, bool $attrib)
    {
        // Retrieve attributes or preferences based on the $attrib parameter
        $data = ($attrib)
            ? $user->attributes()->get()->toArray()
            : $user->preferences()->get()->toArray();

        $excludedColumns = ['id', 'user_id', 'age_range', 'created_at', 'updated_at'];
        $individualValues = [];

        // Extract individual values from each row
        foreach ($data as $item)
        {
            foreach ($item as $columnName => $value)
            {
                // Skip excluded columns
                if (in_array($columnName, $excludedColumns))
                {
                    continue;
                }

                // If the value contains commas, split it into individual values
                $values = explode(',', $value);
                // Add each value to the individual values array
                foreach ($values as $singleValue)
                {
                    $individualValues[] = $singleValue;
                }
            }
        }

        return $individualValues;
    }

    private function calculateSimilarityScore(User $user1, User $user2)
    {
        $user1Age = $this->calculateAge($user1);
        $user2Age = $this->calculateAge($user2);

        $user1AgeRange = $this->getAgeRangeValues($user1);
        $user2AgeRange = $this->getAgeRangeValues($user2);

        $user1Attributes = $this->getIndividualValuesFromList($user1, true);
        $user1Preferences = $this->getIndividualValuesFromList($user1, false);
        $user2Attributes = $this->getIndividualValuesFromList($user2, true);
        $user2Preferences = $this->getIndividualValuesFromList($user2, false);

        $ageScore = 0;
        $attributeScore = 0;
        $preferencesScore = 0;

        $tolerance = 3;

        foreach ($user1AgeRange as $key => $value)
        {
            if ($key === 'min' && $user2Age >= ($value - $tolerance) && isset($user1AgeRange['max']) && $user2Age <= ($user1AgeRange['max'] + $tolerance))
            {
                $ageScore++;
            }
            elseif ($key === 'max' && $user2Age <= ($value + $tolerance) && isset($user1AgeRange['min']) && $user2Age >= ($user1AgeRange['min'] - $tolerance))
            {
                $ageScore++;
            }
        }

        // Calculate similarity score for attributes
        foreach ($user1Attributes as $attribute) {
            if (in_array($attribute, $user2Attributes)) {
                $attributeScore++;
            }
        }

        // Calculate similarity score for preferences
        foreach ($user1Preferences as $preference) {
            if ($preference === "Does not matter") {
                continue;
            }

            if (in_array($preference, $user2Preferences)) {
                $preferencesScore++;
            }
        }

        return [$ageScore, $attributeScore, $preferencesScore];
    }

    /**
     * Display a listing of the resource.
     */
    public function matchmaking()
    {
        $this->authorize('view', MatchingController::class);

        $currentUser = Auth::user();
        $currentUserGenderPrefrence = $currentUser->preferences->gender;

        // Get liked user IDs for the current user
        $likedUserIds = Like::where('user_id', $currentUser->id)
            ->pluck('liked_user_id')
            ->toArray();

        $users = User::where('id', '!=', $currentUser->id)
            ->whereNotIn('id', $likedUserIds)
            ->get();

        $potentialMatches = [];

        foreach ($users as $user)
        {
            if ($user->gender === $currentUserGenderPrefrence || $currentUserGenderPrefrence === 'Does not matter') {
                $scores = [
                    'ageScore' => $this->calculateSimilarityScore($currentUser, $user)[0],
                    'attributeScore' => $this->calculateSimilarityScore($currentUser, $user)[1],
                    'preferencesScore' => $this->calculateSimilarityScore($currentUser, $user)[2],
                ];

                $potentialMatches[] = [
                    'user' => [
                        'information' => $user,
                        'scores' => $scores
                    ]
                ];
            }
        }

        usort($potentialMatches, function($a, $b) {
            $totalScoreA = array_sum($a['user']['scores']);
            $totalScoreB = array_sum($b['user']['scores']);

            // Compare total scores
            if ($totalScoreA === $totalScoreB) {
                return 0;
            }
            return ($totalScoreA < $totalScoreB) ? 1 : -1;
        });

        $potentialMatchesPhotos = [];

        foreach ($potentialMatches as $key => $potentialMatch)
        {
            $user = $potentialMatch['user']['information'];

            $potentialMatchHasPhotos = $user->hasPhotos()->get();

            if ($potentialMatchHasPhotos->isEmpty())
            {
                unset($potentialMatches[$key]);
            }
            else
            {
                $potentialMatchesPhotos[$user->id] = $user->photos;
            }
        }

        return Inertia::render('Matchmaking/Game', [
            'user' => $currentUser,
            'potentialMatches' => $potentialMatches,
            'potentialMatchesPhotos' => $potentialMatchesPhotos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('update', MatchingController::class);

        $validated = $request->validate([
            'user1_id' => 'required|integer',
            'user2_id' => 'required|integer',
        ]);

        $user1 = $validated['user1_id'];
        $user2 = $validated['user2_id'];

        $existingRecord = null;

        event(new UserNotification($user1, $user2, "Match"));
        event(new UserNotification($user2, $user1, "Match"));

        DB::transaction(function () use ($user1, $user2) {
            $existingRecord = Matching::where('user1_id', $user1)
                ->where('user2_id', $user2)
                ->lockForUpdate()
                ->first();

            if (!$existingRecord)
            {
                Matching::create([
                    'user1_id' => $user1,
                    'user2_id' => $user2,
                ]);

                event(new CreateChatRoom($user1, $user2));
            }
        });
    }
}
