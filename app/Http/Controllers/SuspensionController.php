<?php

namespace App\Http\Controllers;

use App\Models\Suspension;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class SuspensionController extends Controller
{
    public function index(): Response
    {
        $user = Auth::user();

        return Inertia::render('Suspended');
    }
}
