<?php

namespace App\Services;

use App\Models\User;
use App\Models\Ticket;
use App\Models\TicketMessage;

class TicketMessageService
{

    public function create(User $user, string $text, Ticket $ticket): TicketMessage
    {
        return TicketMessage::create([
            'ticket_id' => $ticket->id, 'user_id' => $user->id, 'message' => $text
        ]);
    }
}
