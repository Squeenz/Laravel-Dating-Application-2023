<?php

namespace App\Http\Controllers;

use App\Models\Matching;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class MatchingController extends Controller
{
    public function index(): Response
    {
        $user = User::find(Auth::user()->id);

        $matches = Matching::where('user1_id', $user->id)
                ->orWhere('user2_id', $user->id)
                ->get();

        return Inertia::render('Matches/Matches', [
            'matches' => $matches,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function matchmaking()
    {
        $user = Auth::user();

        $userInterests = explode(',', $user->interests);

        // Get users with similar interests excluding the current user
        $potentialMatches = User::where('id', '!=', $user->id)
        ->where(function ($query) use ($userInterests) {
            foreach ($userInterests as $interest) {
                $query->orWhere('interests', 'LIKE', '%' . $interest . '%');
            }
        })
        ->where(function ($query) use ($user) {
            $query->whereNotExists(function ($subQuery) use ($user) {
                $subQuery->select(DB::raw(1))
                        ->from('likes')
                        ->whereRaw('likes.liked_user_id = users.id')
                        ->where('likes.user_id', $user->id);
            });
        })
        ->get();

        // Calculate the number of matching interests for each user
        foreach ($potentialMatches as $potentialMatch) {
            $potentialMatch->matchingInterestsCount = count(array_intersect(explode(',', $potentialMatch->interests), $userInterests));
        }

        // Order the potential matches by the number of matching interests in descending order
        $potentialMatches = $potentialMatches->sortByDesc('matchingInterestsCount');

        $potentialMatchesPhotos = [];

        foreach ($potentialMatches as $potentialMatch) {
            $potentialMatchesPhotos[$potentialMatch->id] = $potentialMatch->photos;
        }

        // You can limit the results to 10 after sorting
        $potentialMatches = $potentialMatches->take(10);

        return Inertia::render('Matchmaking/Game', [
            'user' => Auth::user(),
            'potentialMatches' => $potentialMatches,
            'potentialMatchesPhotos' => $potentialMatchesPhotos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user1_id' => 'required|integer',
            'user2_id' => 'required|integer',
        ]);

        $user1 = $validated['user1_id'];
        $user2 = $validated['user2_id'];

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
            }
        });
    }
}
