<?php

namespace App\Http\Controllers;

use App\Models\Identity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class IdentityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', IdentityController::class);
        return Inertia::render('Identity/Index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        $this->authorize('create', IdentityController::class);
        return Inertia::render('Identity/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'self.*' => 'required|image|mimes:jpeg,png,jpg',
            'document.*' => 'required|image|mimes:jpeg,png,jpg',
        ]);

        $validated['user'] = $user->id;

        if ($request->hasFile('self') && $request->hasFile('document'))
        {
            $self = $request->file('self');
            $document = $request->file('document');

            $self[0]->store('evidence', 'private');
            $document[0]->store('evidence', 'private');

            $validated['self'] = $self[0]->hashName();
            $validated['document'] = $document[0]->hashName();
        }

        Identity::create($validated);

        return redirect(route('identity.index'));
    }
}
