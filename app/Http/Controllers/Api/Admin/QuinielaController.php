<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Quiniela;
use App\Http\Resources\QuinielaResource;
use App\Http\Requests\StoreQuinielaRequest;
use App\Http\Requests\UpdateQuinielaRequest;

class QuinielaController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('quiniela.index');

        return QuinielaResource::collection((Quiniela::paginate(10)));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuinielaRequest $request)
    {
        $this->authorize('quiniela.store');

        $quiniela = Quiniela::create($request->except('games'));

        $quiniela->games()->attach(
            collect($request->games)->pluck('id')
        );

        return new QuinielaResource($quiniela);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiniela $quiniela)
    {
        $this->authorize('quiniela.show');

        return new QuinielaResource($quiniela);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuinielaRequest $request, Quiniela $quiniela)
    {
        $this->authorize('quiniela.update');

        $gameRequestIds = collect($request->games)->pluck('id');
        if ($quiniela->tickets()->count() > 0) {
            $quinielaGamesCount = $quiniela->games()->count();
            if (
                count($request->games) !== $quinielaGamesCount ||
                !empty(
                    $quiniela->games->pluck('id')->diff(
                        $gameRequestIds
                    )->all()
                )
            ) {
                return response()->json(['message' => 'Cannot update the games because tickets have already been created.'], 422);
            }
        }

        $quiniela->update($request->except('games'));

        $quiniela->games()->sync($gameRequestIds);

        return new QuinielaResource($quiniela);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiniela $quiniela)
    {
        $this->authorize('quiniela.destroy');

        $quiniela->games()->detach();

        $quiniela->delete();

        return $this->noContent();
    }
}
