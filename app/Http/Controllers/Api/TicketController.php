<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Domain\Tickets\Models\Ticket;
use App\Domain\Tickets\Services\TicketService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function __construct(
        private TicketService $ticketService
    ) {}

    public function index(Request $request): JsonResponse
    {
        $tickets = $this->ticketService->listActiveForUser(
            $request->user()->id
        );

        return response()->json([
            'data' => $tickets
        ]);
    }

    public function archiveIndex(Request $request): JsonResponse
    {
        $tickets = $this->ticketService->listArchivedForUser(
            $request->user()->id
        );

        return response()->json([
            'data' => $tickets
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['nullable', 'in:low,normal,high'],
        ]);

        $ticket = $this->ticketService->create([
            'creator_id' => $request->user()->id,
            'assignee_id' => null,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'status' => 'open',
            'priority' => $validated['priority'] ?? 'normal',
            'is_archived' => false,
            'archived_at' => null,
        ]);

        return response()->json([
            'data' => $ticket
        ], 201);
    }

    public function show(Request $request, Ticket $ticket): JsonResponse
    {
        abort_unless(
            $ticket->creator_id === $request->user()->id,
            403
        );

        return response()->json([
            'data' => $ticket
        ]);
    }

    public function update(Request $request, Ticket $ticket): JsonResponse
    {
        abort_unless(
            $ticket->creator_id === $request->user()->id,
            403
        );

        $validated = $request->validate([
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'status' => ['sometimes', 'in:open,in_progress,resolved,closed'],
            'priority' => ['sometimes', 'in:low,normal,high'],
            'assignee_id' => ['sometimes', 'nullable', 'exists:users,id'],
        ]);

        $ticket = $this->ticketService->update($ticket, $validated);

        return response()->json([
            'data' => $ticket
        ]);
    }

    public function archive(Request $request, Ticket $ticket): JsonResponse
    {
        abort_unless(
            $ticket->creator_id === $request->user()->id,
            403
        );

        $this->ticketService->archive($ticket);

        return response()->json([
            'message' => 'Ticket archived.'
        ]);
    }
}