<?php

namespace App\Http\Controllers\Api;

use App\Models\Pick;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Quiniela;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Resources\TicketResource;
use App\Actions\Ticket\StoreTicketAction;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quiniela $quiniela)
    {
        $limit = $request->limit ?? $this->getDefaultPageLimit();;

        $tickets = QueryBuilder::for(Ticket::class)
            ->allowedFilters([
                'user_id',
                'quiniela_id'
            ])
            ->allowedSorts(['created_at', 'earned', 'position'])
            ->defaultSorts(['position', '-created_at'])
            ->allowedIncludes(['user', 'quiniela', 'picks']);

        return TicketResource::collection(($tickets->paginate($limit)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, Quiniela $quiniela)
    {
        $this->authorize('store', [Ticket::class, $quiniela]);

        $ticket = (new StoreTicketAction)->execute($request, auth()->user(), $quiniela);

        return new TicketResource($ticket);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Quiniela $quiniela, Ticket $ticket)
    {
        return new TicketResource($ticket);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Quiniela $quiniela, Ticket $ticket)
    {
        $this->authorize('update', $ticket);

        foreach ($request->picks as $pick) {
            Pick::where('id', $pick['id'])->update($pick);
        }

        return new TicketResource($ticket);
    }

}
