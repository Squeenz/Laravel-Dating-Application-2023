<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $allOptios = Attribute::getAllOptions();

        return Inertia::render('Attributes/Index', [
            'allOptions' =>  $allOptios,
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
        $validated = $request->validate(Attribute::rules());

        $validated['user_id'] = $user;

        Attribute::create($validated);

        return redirect(route('matchmaking'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Attribute $userAttribute)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attribute $userAttribute)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attribute $userAttribute)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAttribute $userAttribute)
    {
        //
    }
}
