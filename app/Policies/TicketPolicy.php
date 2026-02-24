<?php

namespace App\Policies;

use App\Models\User;
use App\Domain\Tickets\Models\Ticket;

class TicketPolicy
{
    public function view(User $user, Ticket $ticket): bool
    {
        return $ticket->creator_id === $user->id;
    }

    public function update(User $user, Ticket $ticket): bool
    {
        return $ticket->creator_id === $user->id;
    }

    public function archive(User $user, Ticket $ticket): bool
    {
        return $ticket->creator_id === $user->id;
    }
}