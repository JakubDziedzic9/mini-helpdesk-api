<?php

namespace App\Domain\Tickets\Repositories;

use App\Domain\Tickets\Models\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface CommentRepository
{
    public function create(array $attributes): Comment;

    public function paginateForTicket(int $ticketId, int $perPage = 15): LengthAwarePaginator;
}