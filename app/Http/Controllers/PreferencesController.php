<?php

namespace App\Http\Controllers;

use App\Models\Preferences;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class PreferencesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        return Inertia::render('Preferences/Index');
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
    public function store(Request $request)
    {
        //
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
