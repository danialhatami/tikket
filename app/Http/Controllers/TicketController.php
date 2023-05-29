<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketMessage;
use App\Services\TicketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Services\TicketMessageService;

class TicketController extends Controller
{

    private TicketService $ticketService;
    private TicketMessageService $ticketMessageService;

    /**
     * @param TicketService $ticketService
     */
    public function __construct(TicketService $ticketService, TicketMessageService $ticketMessageService)
    {
        $this->ticketService = $ticketService;
        $this->ticketMessageService = $ticketMessageService;
    }


    public function index(): JsonResponse
    {
        $user = Auth::user();
        $tickets = $this->ticketService->ticketsList($user);
        return response()->json(['data' => $tickets]);
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'description' => 'required|string|max:200',
        ]);
        try {
            $ticket = $this->ticketService->create(text: $request->input('description'));
        } catch (Exception $e) {
            return response()->json(
                [
                    'message' => $e->getMessage()
                ],
                422
            );
        }

        return response()->json(
            [
                'message' => trans('ticket.response_messages.ticket_created'),
                'data' => $ticket
            ],
            201
        );

    }

    public function reply(Request $request, Ticket $ticket): JsonResponse
    {

        $request->validate([
            'reply' => 'required|string|max:200',
        ]);

        $reply = $this->ticketMessageService->create(user: auth(), text: $request->input('reply'), ticket: $ticket);
        return response()->json(
            [
                'message' => trans('ticket.response_messages.ticket_message_created'),
                'data' => $reply
            ],
            201
        );
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (!$ticket->isCreatedBy($user) && !$ticket->isAssignedTo($user)) {
            abort(403, 'Unauthorized');
        }

        return response()->json($ticket);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);

        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (!$ticket->isCreatedBy($user) && !$ticket->isAssignedTo($user)) {
            abort(403, 'Unauthorized');
        }

        $ticket->title = $request->input('title');
        $ticket->description = $request->input('description');
        $ticket->save();

        return response()->json($ticket);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): JsonResponse
    {
        $ticket = Ticket::findOrFail($id);
        $user = Auth::user();

        if (!$ticket->isCreatedBy($user)) {
            abort(403, 'Unauthorized');
        }

        $ticket->delete();

        return response()->json(null, 204);
    }
}
