<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Suspension;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class StaffSuspensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $suspensions = Suspension::all();

        return Inertia::render('Staff/Users/Suspensions', [
            'suspensions' => $suspensions,
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'report' => 'required|integer',
            'handler' => 'required|integer',
            'note' => 'nullable',
            'from' => 'nullable',
            'to' => 'nullable',
        ]);

        Suspension::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Suspension $suspension)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Suspension $suspension)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Suspension $suspension)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Suspension $suspension)
    {
        //
    }
}
