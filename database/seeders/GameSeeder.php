<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $data = [
        //     [
        //         'home_team' => 1,
        //         'away_team' => 2,
        //         'start_at'  => now()->addHours(6)
        //     ],
        //     [
        //         'home_team' => 3,
        //         'away_team' => 4,
        //         'start_at'  => now()->addHours(6)
        //     ],
        //     [
        //         'home_team' => 5,
        //         'away_team' => 6,
        //         'start_at'  => now()->addHours(6)
        //     ],
        // ];

        $data = [];
        $italyTeams = Team::where('country_id', 107)->get();

        $data[] = [
            'home_team' => $italyTeams->where('name', 'Ac Milan')->first()->id,
            'away_team' => $italyTeams->where('name', 'Udinese')->first()->id,
            'start_at'  => now()->addHours(6)
        ];

        $data[] = [
            'home_team' => $italyTeams->where('name', 'Lecce')->first()->id,
            'away_team' => $italyTeams->where('name', 'Inter')->first()->id,
            'start_at'  => now()->addHours(6)
        ];

        $data[] = [
            'home_team' => $italyTeams->where('name', 'Lazio')->first()->id,
            'away_team' => $italyTeams->where('name', 'Bologna')->first()->id,
            'start_at'  => now()->addHours(6)
        ];

        $data[] = [
            'home_team' => $italyTeams->where('name', 'Salernitana')->first()->id,
            'away_team' => $italyTeams->where('name', 'Roma')->first()->id,
            'start_at'  => now()->addHours(6)
        ];

        $data[] = [
            'home_team' => $italyTeams->where('name', 'Juventus')->first()->id,
            'away_team' => $italyTeams->where('name', 'Sassuolo')->first()->id,
            'start_at'  => now()->addHours(6)
        ];

        Game::insert($data);
    }
}
