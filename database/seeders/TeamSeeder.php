<?php

namespace Database\Seeders;

use App\Models\Team;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $path = base_path('database/seeders/teams.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);

        // $countries = Country::all();
        // $teams = [];
        // foreach ($countries as $country) {
        //     $teams[] = [
        //         'country_id' => $country->id,
        //         'is_country' => true
        //     ];
        // }

        // // Italy teams
        // $italy = Country::where('name', 'Italy')->first();

        // $italyTeams = [
        //     [
        //         'name' => 'Ac Milan',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Juventus',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Inter',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Napoli',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Lazio',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Roma',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Atalanta',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Udinese',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Fiorentina',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Bologna',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Torino',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Sassuolo',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Monza',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Empoli',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Lecce',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Salernitana',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Spezia',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Verona',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Sampdoria',
        //         'country_id' => $italy->id
        //     ],
        //     [
        //         'name' => 'Cremonese',
        //         'country_id' => $italy->id
        //     ]
        // ];

        // // England teams
        // $england = Country::where('name', 'United Kingdom')->first();

        // $englandteams = [
        //     [
        //         'name' => 'Arsenal',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Manchester City',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Manchester United',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Tottenham',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Newcastle',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Liverpool',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Brighton',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Brentford',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Fulham',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Chelsea',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Aston Villa',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Crystal Palace',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Wolves',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Leeds United',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Everton',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Nottingham Forest',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Leicester City',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'West Ham',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Bournemouth',
        //         'country_id' => $england->id
        //     ],
        //     [
        //         'name' => 'Southampton',
        //         'country_id' => $england->id
        //     ],
        // ];

        // // Spain teams
        // $spain = Country::where('name', 'Spain')->first();

        // $spainTeams = [
        //     [
        //         'name' => 'Real Madrid',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Barcelona',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Atlético Madrid',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Real Sociedad',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Real Betis',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Villareal',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Athletic Club',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Rayo Vallecano',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Osasuna',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Celta de Vigo',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Mallorca',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Girona',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Getafe',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Sevilla',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Cádiz',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Valladolid',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Espanyol',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Valencia',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Almería',
        //         'country_id' => $spain->id
        //     ],
        //     [
        //         'name' => 'Elche',
        //         'country_id' => $spain->id
        //     ],
        // ];

        // // France teams
        // $france = Country::where('name', 'Spain')->first();

        // $franceTeams = [
        //     [
        //         'name' => 'PSG',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Marseille',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Lens',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Monaco',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Rennes',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'LOSC Lille',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Nice',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Lorient',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Reims',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Lyon',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Montpellier',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Toulouse',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Clermont Foot',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Nantes',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Strasbourg',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Brest',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Auxerre',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Troyes',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Ajaccio',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Angers',
        //         'country_id' => $france->id
        //     ]
        // ];

        // // Germany teams
        // $germany = Country::where('name', 'Germany')->first();

        // $germanyTeams = [
        //     [
        //         'name' => 'Bayern Munich',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Dortmund',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Union Berlin',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'SC Freiburg',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'RB Leipzig',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Eintracht Frankfurt',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Wolfsburg',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Leverkusen',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Mainz',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Borussia Mönchengladbach',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Werder Bremen',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Augsburg',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Koln',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'VFL Bochum',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Hoffenheim',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Hertha Berlin',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'Shalke 04',
        //         'country_id' => $france->id
        //     ],
        //     [
        //         'name' => 'VfB Sttutgart',
        //         'country_id' => $france->id
        //     ],
        // ];

        // Team::insert($teams);
        // Team::insert(array_merge($italyTeams, $englandteams, $spainTeams, $germanyTeams, $franceTeams));
    }
}
