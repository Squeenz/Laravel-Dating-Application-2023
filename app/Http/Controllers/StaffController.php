<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Matching;
use App\Models\SupportTicket;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;
use PHPUnit\Framework\Attributes\Ticket;

class StaffController extends Controller
{
    public function index(): Response
    {
        $this->authorize('view', StaffController::class);

        $users = User::all()->count();
        $likes = Like::where('is_like', 1)->count();
        $matches = Matching::all()->count();
        $totalTickets = SupportTicket::all()->count();
        $openTickets = SupportTicket::where('status', 0)->count();
        $closedTickets = SupportTicket::where('status', 2)->count();

        return Inertia::render('Staff/Dashboard', [
            'users' => $users,
            'likes' => $likes,
            'matches' => $matches,
            'totalTickets' => $totalTickets,
            'openTickets' => $openTickets,
            'closedTickets' => $closedTickets
        ]);
    }
}
