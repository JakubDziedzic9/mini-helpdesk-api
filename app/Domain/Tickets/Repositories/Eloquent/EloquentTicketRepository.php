<?php

namespace App\Domain\Tickets\Repositories\Eloquent;

use App\Domain\Tickets\Models\Ticket;
use App\Domain\Tickets\Repositories\TicketRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentTicketRepository implements TicketRepository
{
    public function create(array $attributes): Ticket
    {
        return Ticket::query()->create($attributes);
    }

    public function findById(int $id): ?Ticket
    {
        return Ticket::query()->find($id);
    }

    public function findOrFail(int $id): Ticket
    {
        return Ticket::query()->findOrFail($id);
    }

    public function save(Ticket $ticket): Ticket
    {
        $ticket->save();

        return $ticket;
    }

    public function paginate(int $perPage = 15): LengthAwarePaginator
    {
        return Ticket::query()->latest()->paginate($perPage);
    }
}