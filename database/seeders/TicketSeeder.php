<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Generator;
use App\Models\Ticket;
use App\Models\Quiniela;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TicketSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quiniela = Quiniela::first();
        $games = $quiniela->games;
        $users = User::pluck('id')->toArray();
        $faker = new Generator();

        for ($i=0; $i < 20; $i++) {
            $ticket = Ticket::create([
                'user_id' => fake()->randomElement($users),
                'quiniela_id' => $quiniela->id,
                'price' => $quiniela->ticket_price
            ]);

            foreach ($games as $game) {
                $picks[] = [
                    'game_id' => $game->id,
                    'home_score' => fake()->numberBetween(0, 4),
                    'away_score' => fake()->numberBetween(0, 4)
                ];
            }

            $ticket->picks()->createMany($picks);
            unset($picks);
        }
    }
}
