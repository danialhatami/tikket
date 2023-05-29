<?php

namespace App\Services;

use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class TicketService
{

    public function ticketsList(?\Illuminate\Contracts\Auth\Authenticatable $user): Collection
    {
        if ($user->hasRole('admin')) {
            $tickets = Ticket::all();
        } elseif ($user->hasRole('employee')) {
            $tickets = Ticket::where('assignee_id', $user->id)->get();
        } else {
            $tickets = Ticket::where('creator_id', $user->id)->get();
        }
        return $tickets;
    }

    public function create(string $text): Collection
    {
        $ticket = DB::transaction(function () use ($text) {
            $ticket = Ticket::create([
                'description' => $text,
                'user_id' => auth()->id(),
            ]);

            // Assign the ticket to the employee with the fewest assigned tickets
            $employee = User::whereRole('employee')
                ->withCount('assignedTickets')
                ->orderBy('assigned_tickets_count')
                ->first();
            if (!$employee) {
                throw new \Exception('No employee found.');
            }
            $ticket->assignee_id = $employee->id;
            $ticket->save();
            return $ticket;
        });

        return $ticket;
    }
}
