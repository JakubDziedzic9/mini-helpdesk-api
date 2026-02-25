<?php

namespace App\Domain\Tickets\Transitions;

use App\Domain\Tickets\Models\Ticket;

interface TicketStatusTransition
{
    public function canTransition(Ticket $ticket): bool;

    public function apply(Ticket $ticket): Ticket;

    public function targetStatus(): string;
}