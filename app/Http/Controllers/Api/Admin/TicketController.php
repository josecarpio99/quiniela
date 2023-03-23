<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Pick;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Quiniela;
use App\Http\Resources\TicketResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\StoreTicketRequest;
use App\Http\Requests\Admin\UpdateTicketRequest;
use App\Http\Requests\Admin\DestroyTicketRequest;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Quiniela $quiniela)
    {
        $this->authorize('admin.ticket.index');

        return TicketResource::collection((Ticket::paginate(10)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, Quiniela $quiniela)
    {
        $this->authorize('admin.ticket.store');

        $user = User::find($request->user_id);

        if (! $quiniela->is_active || now()->gt($quiniela->close_at)) {
            return $this->error('Quiniela is inactive or already closed');
        }

        if ($user->balance < $quiniela->ticket_price) {
            return $this->error('insufficient user funds');
        }

        if (
            ! $quiniela->gamesMatch(collect($request->picks)->pluck('game_id')->all())
        ) {
            return $this->error('Game/s dont belong to quiniela');
        }

        $ticket = $quiniela->tickets()->create([
            'user_id' => $request->user_id,
            'created_by' => auth()->user()->id,
            'price' => $quiniela->ticket_price,
        ]);

        $ticket->picks()->createMany($request->picks);

        $user->decrement('balance', $quiniela->ticket_price);

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
        $this->authorize('admin.ticket.show');

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
        $this->authorize('admin.ticket.update');

        if (! $quiniela->is_active || now()->gt($quiniela->close_at)) {
            return $this->error('Quiniela is inactive or already closed');
        }

        foreach ($request->picks as $pick) {
            Pick::where('id', $pick['id'])->update($pick);
        }

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(DestroyTicketRequest $request, Quiniela $quiniela, Ticket $ticket)
    {
        $this->authorize('admin.ticket.destroy');

        if ($request->update_user_balance) {
            $ticket->user()->increment('balance', $ticket->price);
        }

        $ticket->delete();

        return $this->noContent();
    }
}
