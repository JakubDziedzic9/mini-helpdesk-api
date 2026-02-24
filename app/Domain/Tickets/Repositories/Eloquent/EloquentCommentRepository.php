<?php

namespace App\Domain\Tickets\Repositories\Eloquent;

use App\Domain\Tickets\Models\Comment;
use App\Domain\Tickets\Repositories\CommentRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentCommentRepository implements CommentRepository
{
    public function create(array $attributes): Comment
    {
        return Comment::query()->create($attributes);
    }

    public function paginateForTicket(int $ticketId, int $perPage = 15): LengthAwarePaginator
    {
        return Comment::query()
            ->where('ticket_id', $ticketId)
            ->latest()
            ->paginate($perPage);
    }
}