<?php

namespace App\Domain\Tickets\Transitions;

use App\Domain\Tickets\Models\Ticket;

class ResolvedToClosedTransition implements TicketStatusTransition
{
    public function canTransition(Ticket $ticket): bool
    {
        return $ticket->status === 'resolved';
    }

    public function apply(Ticket $ticket): Ticket
    {
        if (! $this->canTransition($ticket)) {
            throw new \DomainException('Invalid status transition.');
        }

        $ticket->status = 'closed';
        $ticket->save();

        return $ticket->fresh();
    }

    public function targetStatus(): string
    {
        return 'closed';
    }
}