<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportTicketChatRoom;
use App\Models\User;
use App\Policies\StaffSupportTicketPolicy;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;
use Ramsey\Uuid\Type\Integer;

class StaffSupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $this->authorize('viewAny', StaffSupportTicketController::class);

        $tickets = SupportTicket::all();

        return Inertia::render('Staff/Support/Support',[
            'tickets' => $tickets,
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        $this->authorize('viewAny', StaffSupportTicketController::class);

        $tickets = SupportTicket::all();

        $supportTicket->supportChatRoom->supportChatMessages->map(function ($message) {
            $message->content = decrypt($message->content);
            return $message;
        });

        $user = User::findOrFail($supportTicket->user);

        $supportTicket->supportChatRoom->handler === 0 ? $hasHandler = false: $hasHandler = true;

        return Inertia::render('Staff/Support/Support',[
            'tickets' => $tickets,
            'selectedTicket' => $supportTicket,
            'hasHandler' => $hasHandler,
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateStatus(SupportTicket $supportTicket, string $status): RedirectResponse
    {
        $this->authorize('update', StaffSupportTicketController::class);

        $supportTicket->status = $status;

        $supportTicket->update();

        return redirect(route('staff.dashboard.tickets.show', $supportTicket));
    }

        /**
     * Update the specified resource in storage.
     */
    public function updateHandlerAndStatus(SupportTicket $supportTicket): RedirectResponse
    {
        $this->authorize('updateHandlerStatus', StaffSupportTicketController::class);

        $staffUser = Auth::user();

        $supportTicket->status = 1;
        $supportTicket->update();

        $supportTicketChatRoom = SupportTicketChatRoom::findOrFail($supportTicket->support_chat_room);

        $supportTicketChatRoom->handler = $staffUser->id;
        $supportTicketChatRoom->update();

        return redirect(route('staff.dashboard.tickets.show', $supportTicket));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
