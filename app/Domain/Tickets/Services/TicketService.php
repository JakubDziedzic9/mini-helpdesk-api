<?php

namespace App\Domain\Tickets\Services;

use App\Domain\Tickets\Repositories\TicketRepository;
use App\Domain\Tickets\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class TicketService
{
    public function __construct(
        private TicketRepository $tickets
    ) {}

    public function listActiveForUser(int $userId)
    {
        return $this->tickets->listActiveForUser($userId);
    }

    public function listArchivedForUser(int $userId)
    {
        return $this->tickets->listArchivedForUser($userId);
    }

    public function create(array $data): Ticket
    {
        return $this->tickets->create($data);
    }

    public function update(Ticket $ticket, array $data): Ticket
    {
        $ticket->update($data);
        return $ticket->fresh();
    }

    public function archive(Ticket $ticket): void
    {
        $ticket->update([
            'is_archived' => true,
            'archived_at' => now(),
        ]);
    }
}