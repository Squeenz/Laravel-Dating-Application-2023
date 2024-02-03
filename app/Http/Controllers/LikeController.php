<?php

namespace App\Http\Controllers;

use App\Events\MatchFound;
use App\Models\Like;
use App\Models\User;

use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $status)
    {
        if ($status == 0 || $status == 1)
        {
            $validated = $request->validate([
                'user_id' => 'integer|required',
                'liked_user_id' => 'integer|required',
                'is_like' => 'integer|required'
            ]);

            $validated['is_like'] = $status;

            Like::create($validated);

            $user = User::find($validated['user_id']);
            $likedUser = User::find($validated['liked_user_id']);

            // Check if it's a mutual like
            if ($user->likes->where('liked_user_id', $likedUser->id)->isNotEmpty() && $likedUser->likes->where('liked_user_id', $user->id)->isNotEmpty()) {
                event(new MatchFound($user, $likedUser));
            }
        }
        else
        {
            return error(404);
        }
    }
}
