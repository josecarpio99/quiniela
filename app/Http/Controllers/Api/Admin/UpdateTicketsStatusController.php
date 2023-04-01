<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\TicketStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Models\Quiniela;

class UpdateTicketsStatusController extends ApiController
{
    public function __invoke(Quiniela $quiniela)
    {
        $quiniela->prize = $quiniela->prize->map(function($prize, $key) use($quiniela) {
            $prize['winners'] = $quiniela->tickets()->where('position', $prize['position'])->count();
            $prize['earned']  = $prize['winners'] ? $prize['amount'] / $prize['winners'] : $prize['amount'];
            return $prize;
        });

        $positionsRewarded = $quiniela->prize->pluck('position')->all();

        $quiniela->prize->each(function($prize) use($quiniela) {
            $quiniela->tickets()
                ->where('position', $prize['position'])
                ->update([
                    'status' => TicketStatusEnum::Winner,
                    'earned' => $prize['earned'],
                ]);
        });

        $quiniela->tickets()
            ->whereNotIn('position', $positionsRewarded)
            ->update([
                'status' => TicketStatusEnum::Loser,
                'earned' => 0
            ]);

        return $this->noContent();
    }
}
