<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $employees = User::whereRole('employee')->get();
//
//        Ticket::factory(10)->create()->each(function ($ticket) use ($employees) {
//            $ticket->assignee_id = $employees->random()->id;
//            $ticket->save();
//        });
    }
}
