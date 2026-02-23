<?php

namespace Database\Seeders;

use App\Domain\Tickets\Models\Comment;
use App\Domain\Tickets\Models\Ticket;
use App\Domain\Tickets\Models\TicketHistory;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::factory()->count(5)->create();

        $tickets = Ticket::factory()
            ->count(10)
            ->state(fn () => [
                'creator_id' => $users->random()->id,
                'assignee_id' => $users->random()->id,
            ])
            ->create();

        foreach ($tickets as $ticket) {
            Comment::factory()->count(2)->create([
                'ticket_id' => $ticket->id,
                'user_id' => $users->random()->id,
            ]);

            TicketHistory::factory()->count(2)->create([
                'ticket_id' => $ticket->id,
                'actor_id' => $users->random()->id,
            ]);
        }
    }
}
