<?php

namespace Database\Factories;

use App\Domain\Tickets\Models\TicketHistory;
use App\Domain\Tickets\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketHistoryFactory extends Factory
{
    protected $model = TicketHistory::class;

    public function definition(): array
    {
        return [
            'ticket_id' => Ticket::factory(),
            'actor_id' => User::factory(),
            'action' => $this->faker->randomElement(['created', 'status_changed', 'assigned', 'archived', 'comment_added']),
            'changes' => ['example' => 'value'],
        ];
    }
}
