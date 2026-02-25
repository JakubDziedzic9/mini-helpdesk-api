<?php

namespace App\Domain\Tickets\Transitions;

class TicketStatusTransitionFactory
{
    public static function make(string $from, string $to): TicketStatusTransition
    {
        return match ("$from->$to") {
            'open->in_progress' => new OpenToInProgressTransition(),
            'in_progress->resolved' => new InProgressToResolvedTransition(),
            'resolved->closed' => new ResolvedToClosedTransition(),
            default => throw new \DomainException('Transition not allowed.'),
        };
    }
}