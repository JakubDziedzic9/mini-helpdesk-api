<?php

namespace App\Domain\Tickets\Transitions;

use App\Domain\Tickets\Models\Ticket;

class OpenToInProgressTransition implements TicketStatusTransition
{
    public function canTransition(Ticket $ticket): bool
    {
        return $ticket->status === 'open';
    }

    public function apply(Ticket $ticket): Ticket
    {
        if (! $this->canTransition($ticket)) {
            throw new \DomainException('Invalid status transition.');
        }

        $ticket->status = 'in_progress';
        $ticket->save();

        return $ticket->fresh();
    }

    public function targetStatus(): string
    {
        return 'in_progress';
    }
}