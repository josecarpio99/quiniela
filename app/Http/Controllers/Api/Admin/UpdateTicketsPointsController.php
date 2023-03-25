<?php

namespace App\Http\Controllers\Api\Admin;

use App\Enums\GameResultPredictionPointsEnum;
use App\Models\Game;
use App\Models\Quiniela;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\UpdateTicketsPointsRequest;
use App\Http\Resources\QuinielaResource;

class UpdateTicketsPointsController extends ApiController
{

    public function __invoke(UpdateTicketsPointsRequest $request, Quiniela $quiniela)
    {
        $this->authorize('ticket.update_points');

        foreach ($request->games as $game) {

            $game = Game::where('id', $game['id'])->update([
                'home_score' => $game['home_score'],
                'away_score' => $game['away_score']
            ]);

            $operator = '>';

            // Update picks failed
            if ($game->home_score < $game->away_score) {

                $operator = '<';

                $quiniela
                    ->picks()
                    ->where('game_id', $game->id)
                    ->whereColumn('away_score', '<=', 'home_score')
                    ->update([
                        'points' => GameResultPredictionPointsEnum::FAILED_RESULT->value
                    ]);

            } elseif ($game->home_score === $game->away_score) {

                $operator = '=';

                $quiniela
                    ->picks()
                    ->where('game_id', $game->id)
                    ->whereColumn('away_score', '>', 'home_score')
                    ->OrWhereColumn('home_score', '>', 'away_score')
                    ->update([
                        'points' => GameResultPredictionPointsEnum::FAILED_RESULT->value
                    ]);

            } else {

                $quiniela
                    ->picks()
                    ->where('game_id', $game->id)
                    ->whereColumn('home_score', '<=', 'away_score')
                    ->update([
                        'points' => GameResultPredictionPointsEnum::FAILED_RESULT->value
                    ]);
            }

            // Update picks with correct result
            $quiniela
                ->picks()
                ->where('game_id', $game->id)
                ->whereColumn('home_score', $operator, 'away_score')
                ->update(['points' => GameResultPredictionPointsEnum::CORRECT_RESULT->value]);

            // Update picks with exact scoreboard
            $quiniela
                ->picks()
                ->where('game_id', $game->id)
                ->where('home_score', $game->home_score)
                ->where('away_score', $game->away_score)
                ->update(['points' => GameResultPredictionPointsEnum::EXACT_SCOREBOARD->value]);
        }

        // Update tickets points
        foreach ($quiniela->tickets() as $ticket) {
            $ticket->update([
                'points' => $ticket->picks->sum('points')
            ]);
        }

        return new QuinielaResource($quiniela);
    }
}
