<?php

namespace Database\Seeders;

use App\Models\Team;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teams = [
            [
                'name' => 'Ac Milan'
            ],
            [
                'name' => 'Juventus'
            ],
            [
                'name' => 'Inter'
            ],
            [
                'name' => 'Napoli'
            ],
            [
                'name' => 'Lazio'
            ],
            [
                'name' => 'Roma'
            ]
        ];

        Team::insert($teams);
    }
}
