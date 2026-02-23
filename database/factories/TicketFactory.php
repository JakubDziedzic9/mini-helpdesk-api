<?php

namespace Database\Factories;

use App\Domain\Tickets\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class TicketFactory extends Factory
{
    protected $model = Ticket::class;

    public function definition(): array
    {
        $archived = $this->faker->boolean(30);

        return [
            'creator_id' => User::factory(),
            'assignee_id' => $this->faker->boolean(70) ? User::factory() : null,
            'title' => $this->faker->sentence(6),
            'description' => $this->faker->paragraph(3),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'resolved', 'closed']),
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'is_archived' => $archived,
            'archived_at' => $archived ? now() : null,
        ];
    }
}

