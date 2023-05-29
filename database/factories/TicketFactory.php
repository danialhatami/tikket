<?php

namespace Database\Factories;

use App\Models\Ticket;
use App\Models\TicketMessage;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{

    protected $model = Ticket::class;

    public function definition()
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },
            'assignee_id' => null,
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Ticket $ticket) {
            $ticket->messages()->save(
                TicketMessage::create([
                    'user_id' => $ticket->user_id,
                    'message' => $this->faker->paragraph,
                    'ticket_id' => $ticket->id
                ])
            );
        });
    }
}
