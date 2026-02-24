<?php

namespace App\Domain\Tickets\Repositories\Eloquent;

use App\Domain\Tickets\Models\TicketHistory;
use App\Domain\Tickets\Repositories\TicketHistoryRepository;

class EloquentTicketHistoryRepository implements TicketHistoryRepository
{
    public function create(array $attributes): TicketHistory
    {
        return TicketHistory::query()->create($attributes);
    }
}