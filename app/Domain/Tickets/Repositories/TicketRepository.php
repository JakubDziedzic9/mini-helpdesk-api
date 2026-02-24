<?php

namespace App\Domain\Tickets\Repositories;

use App\Domain\Tickets\Models\Ticket;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface TicketRepository
{
    public function create(array $attributes): Ticket;

    public function findById(int $id): ?Ticket;

    public function findOrFail(int $id): Ticket;

    public function save(Ticket $ticket): Ticket;

    public function paginate(int $perPage = 15): LengthAwarePaginator;

    public function listActiveForUser(int $userId);
    
    public function listArchivedForUser(int $userId);
}