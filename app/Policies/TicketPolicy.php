<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TicketPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Ticket $ticket)
    {
        return $user->hasAnyRole(['admin', 'employee']) || $ticket->creator_id === $user->id;
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->hasAnyRole(['admin', 'employee']) || $ticket->creator_id === $user->id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->hasRole('admin') || $ticket->creator_id === $user->id;
    }
}
