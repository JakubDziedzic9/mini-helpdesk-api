<?php

namespace App\Domain\Tickets\Transitions;

use App\Domain\Tickets\Models\Ticket;

class InProgressToResolvedTransition implements TicketStatusTransition
{
    public function canTransition(Ticket $ticket): bool
    {
        return $ticket->status === 'in_progress';
    }

    public function apply(Ticket $ticket): Ticket
    {
        if (! $this->canTransition($ticket)) {
            throw new \DomainException('Invalid status transition.');
        }

        $ticket->status = 'resolved';
        $ticket->save();

        return $ticket->fresh();
    }

    public function targetStatus(): string
    {
        return 'resolved';
    }
}