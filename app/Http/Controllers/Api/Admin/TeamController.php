<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Team;
use App\Http\Requests\Admin\StoreTeamRequest;
use App\Http\Requests\Admin\UpdateTeamRequest;
use App\Http\Resources\TeamResource;

class TeamController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('team.index');

        $teams = Team::query()
            ->with('country')
            ->where('is_country', false)
            ->orderBy('name');

        return TeamResource::collection(($teams->paginate(10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTeamRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTeamRequest $request)
    {
        $this->authorize('team.store');

        $team = Team::create($request->validated());

        return new TeamResource($team);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function show(Team $team)
    {
        $this->authorize('team.show');

        return new TeamResource($team);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTeamRequest  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTeamRequest $request, Team $team)
    {
        $this->authorize('team.update');

        $team->update($request->validated());

        return new TeamResource($team);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\Response
     */
    public function destroy(Team $team)
    {
        $this->authorize('team.destroy');

        $team->delete();

        return $this->noContent();
    }
}
