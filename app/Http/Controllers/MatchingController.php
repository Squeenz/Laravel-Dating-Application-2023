<?php

namespace App\Http\Controllers;

use App\Events\CreateChatRoom;
use App\Models\Matching;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Events\UserNotification;
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

    /**
     * Display a listing of the resource.
     */
    public function matchmaking()
    {
        $this->authorize('view', MatchingController::class);

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

        foreach ($potentialMatches as $key => $potentialMatch)
        {
            $potentialMatchHasPhotos = $potentialMatch->hasPhotos()->get();

            if ($potentialMatchHasPhotos->isEmpty())
            {
                unset($potentialMatches[$key]);
            }
            else
            {
                $potentialMatchesPhotos[$potentialMatch->id] = $potentialMatch->photos;
            }
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
