<?php

namespace App\Http\Controllers;

use Inertia\Inertia;
use Inertia\Response;

class StaffController extends Controller
{
    public function index(): Response
    {
        $this->authorize('view', StaffController::class);

        return Inertia::render('Staff/Dashboard');
    }
}
