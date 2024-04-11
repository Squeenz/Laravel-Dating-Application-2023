<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Suspension;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\UserSuspensionNotification;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;
use Spatie\Permission\Models\Role;

class StaffSuspensionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', StaffSuspensionController::class);

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
        $this->authorize('update', StaffSuspensionController::class);

        $validated = $request->validate([
            'report' => 'required|integer',
            'handler' => 'required|integer',
            'suspended' => 'required|integer',
            'note' => 'nullable',
            'from' => 'nullable',
            'to' => 'nullable',
        ]);

        Suspension::create($validated);

        if ($validated['suspended'] === 1)
        {
            $report = Report::findOrFail($validated['report']);

            $user = $report->suspect()->first();

            if ($user)
            {
                $user->assignRole('suspended');
                Notification::send($user, new UserSuspensionNotification($validated['from'], $validated['to'], $report->violated_rule));
            };
        };
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
