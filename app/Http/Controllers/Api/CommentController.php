<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domain\Tickets\Models\Ticket;
use App\Domain\Tickets\Models\Comment;
use App\Domain\Tickets\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
    public function __construct(
        private CommentRepository $commentRepository
    ) {}

    public function index(Request $request, ?Ticket $ticket = null): JsonResponse
    {
        if ($ticket) {
            $comments = $this->commentRepository->paginateForTicket($ticket->id);
        } else {
            $comments = $this->commentRepository->paginateForUser($request->user()->id);
        }

        return response()->json([
            'data' => $comments->items(),
            'pagination' => [
                'total' => $comments->total(),
                'per_page' => $comments->perPage(),
                'current_page' => $comments->currentPage(),
                'last_page' => $comments->lastPage(),
            ]
        ]);
    }

    public function show(Request $request, Comment $comment): JsonResponse
    {
        abort_unless($comment->user_id === $request->user()->id, 403);

        return response()->json(['data' => $comment]);
    }

    public function store(Request $request, Ticket $ticket): JsonResponse
    {
        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $comment = $this->commentRepository->create([
            'ticket_id' => $ticket->id,
            'user_id' => $request->user()->id,
            'body' => $validated['body'],
        ]);

        return response()->json([
            'data' => $comment
        ], 201);
    }

    public function update(Request $request, Comment $comment): JsonResponse
    {
        abort_unless($comment->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'body' => ['required', 'string'],
        ]);

        $comment->update($validated);

        return response()->json(['data' => $comment]);
    }

    public function destroy(Request $request, Comment $comment): JsonResponse
    {
        abort_unless($comment->user_id === $request->user()->id, 403);

        $comment->delete();

        return response()->noContent();
    }
}
