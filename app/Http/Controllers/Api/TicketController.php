<?php

namespace App\Http\Controllers\Api;

use App\Models\Pick;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Quiniela;
use App\Http\Resources\TicketResource;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Quiniela $quiniela)
    {
        $tickets = Ticket::whereUser(auth()->user())
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return TicketResource::collection($tickets);
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

        if (auth()->user()->balance < $quiniela->ticket_price) {
            return $this->error('Insufficient user funds');
        }

        if (
            ! $quiniela->gamesMatch(collect($request->picks)->pluck('game_id')->all())
        ) {
            return $this->error('Game/s dont belong to quiniela');
        }

        $ticket = $quiniela->tickets()->create([
            'user_id' => auth()->user->id,
            'price' => $quiniela->ticket_price,
        ]);

        $ticket->picks()->createMany($request->picks);

        auth()->user()->decrement('balance', $quiniela->ticket_price);

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
        $this->authorize('show', [$ticket, $quiniela]);

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
        $this->authorize('update', [$ticket, $quiniela]);

        foreach ($request->picks as $pick) {
            Pick::where('id', $pick['id'])->update($pick);
        }

        return new TicketResource($ticket);
    }

}
