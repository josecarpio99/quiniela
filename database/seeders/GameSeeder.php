<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'home_team' => 1,
                'away_team' => 2,
                'start_at'  => now()->addHours(6)
            ],
            [
                'home_team' => 3,
                'away_team' => 4,
                'start_at'  => now()->addHours(6)
            ],
            [
                'home_team' => 5,
                'away_team' => 6,
                'start_at'  => now()->addHours(6)
            ],
        ];

        Game::insert($data);
    }
}
