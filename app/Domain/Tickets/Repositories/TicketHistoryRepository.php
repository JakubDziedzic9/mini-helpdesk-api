<?php

namespace App\Domain\Tickets\Repositories;

use App\Domain\Tickets\Models\TicketHistory;

interface TicketHistoryRepository
{
    public function create(array $attributes): TicketHistory;
}