<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Quiniela;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class QuinielaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $quiniela = Quiniela::create([
            'ticket_price' => 2,
            'close_at' => now()->addHours(5),
            'prize' => [
                [
                    'position' => 1,
                    'amount'   => 200
                ],
                [
                    'position' => 2,
                    'amount'   => 50
                ],
            ]
        ]);

        $quiniela->games()->attach(Game::take(3)->get()->pluck('id'));
    }
}
