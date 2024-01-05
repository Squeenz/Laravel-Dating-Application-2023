<?php

namespace App\Http\Controllers;

use App\Models\Like;
use Illuminate\Http\Request;

use function Laravel\Prompts\error;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

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
        }
        else
        {
            return error(404);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Like $like)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Like $like)
    {
        //
    }
}
