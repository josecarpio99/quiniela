<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Game;
use Illuminate\Http\Request;
use App\Http\Resources\GameResource;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\StoreGameRequest;
use App\Http\Requests\Admin\UpdateGameRequest;

class GameController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('game.index');

        $limit = $request->limit ?? $this->getDefaultPageLimit();

        $games = QueryBuilder::for(Game::class)
            ->with(['homeTeam', 'awayTeam'])
            ->allowedFilters([
                AllowedFilter::callback('available', fn (Builder $query) => $query->available())
            ])
            ->allowedSorts(['start_at'])
            ->defaultSort('start_at');

        return GameResource::collection($games->paginateData($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGameRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGameRequest $request)
    {
        $this->authorize('game.store');

        $game = Game::create($request->validated());

        return new GameResource($game);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function show(Game $game)
    {
        $this->authorize('game.show');

        return new GameResource($game);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGameRequest  $request
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGameRequest $request, Game $game)
    {
        $this->authorize('game.update');

        $game->update($request->validated());

        return new GameResource($game);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Game  $game
     * @return \Illuminate\Http\Response
     */
    public function destroy(Game $game)
    {
        $this->authorize('game.destroy');

        $game->delete();

        return $this->noContent();
    }
}
