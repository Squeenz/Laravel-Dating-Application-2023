<?php

namespace App\Http\Controllers;

use App\Models\Preferences;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class PreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $allOptions = Preferences::getAllOptions();

        return Inertia::render('Preferences/Index',[
            'allOptions' => $allOptions,
        ]);
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
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user()->id;

        $validated = $request->validate(Preferences::rules());
        $validated['user_id'] = $user;

        Preferences::create($validated);

        return redirect(route('matchmaking'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Preferences $preferences)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Preferences $preferences)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Preferences $preferences)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Preferences $preferences)
    {
        //
    }
}
