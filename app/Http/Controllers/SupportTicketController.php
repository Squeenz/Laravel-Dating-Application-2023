<?php

namespace App\Http\Controllers;

use App\Models\SupportTicket;
use App\Models\SupportTicketChatRoom;
use App\Models\SupportTicketChatRoomMessages;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class SupportTicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $user = Auth::user();

        $userTickets = $user->supportTickets;

        return Inertia::render('Support/Index', [
            'tickets' => $userTickets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Support/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $validated = $request->validate([
            'reason' => 'required|in:Account Assistance,Profile Management,Technical Support,Privacy Concerns,Feedback and Suggestions,Other Inquiries',
        ]);

        $validated['user'] = $user->id;
        $validated['status'] = 0;

        $ticketChatRoomData = [
            'user' => $user->id,
            'handler' => 0,
        ];

        $supportChatRoom = SupportTicketChatRoom::create($ticketChatRoomData);

        $validated['support_chat_room'] = $supportChatRoom->id;

        $userMessageData = [
            'user' => $user->id,
            'support_chat_room' => $supportChatRoom->id,
            'content' => encrypt($request->message),
        ];

        SupportTicketChatRoomMessages::create($userMessageData);

        $supportTicket = SupportTicket::create($validated);

        return redirect(route('support.show', $supportTicket));
    }

    /**
     * Display the specified resource.
     */
    public function show(SupportTicket $supportTicket)
    {
        $user = Auth::user();

        $userTickets = $user->supportTickets;

        if ($user->id === $supportTicket->user)
        {
            $chatMessages = $supportTicket->supportChatRoom->supportChatMessages->map(function ($message) {
                $message->content = decrypt($message->content);
                return $message;
            });
        }
        else
        {
            return abort(404);
        }

        return Inertia::render('Support/Index', [
            'tickets' => $userTickets,
            'chatMessages' => $chatMessages,
        ]);
    }
}
