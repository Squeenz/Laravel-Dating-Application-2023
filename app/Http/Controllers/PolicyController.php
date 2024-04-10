<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use Illuminate\Http\Request;
use Inertia\Response;
use Inertia\Inertia;

class PolicyController extends Controller
{
    /**
     * Display a listing of the resource.
    */
    public function index(): Response
    {
        $policies = Policy::all();

        return Inertia::render('Policies/Policies',
        [
            'policies' => $policies,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function staffIndex(): Response
    {
        $this->authorize('viewAny', Policy::class);

        $policies = Policy::all();

        return Inertia::render('Staff/Policies/Policies', [
            'policies' => $policies,
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
        $this->authorize('create', Policy::class);

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        Policy::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Policy $policy): Response
    {
        $validPolicy = Policy::findOrFail($policy->id);

        return Inertia::render('Policies/Show', [
            'policy' => $validPolicy,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Policy $policy)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Policy $policy)
    {
        $this->authorize('update', $policy);

        $validated = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $policy->update($validated);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Policy $policy)
    {
        $this->authorize('delete', $policy);
        $policy->delete();
    }
}
