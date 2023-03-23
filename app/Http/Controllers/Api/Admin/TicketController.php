<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Models\Ticket;
use App\Http\Requests\Admin\StoreTicketRequest;
use App\Http\Requests\Admin\UpdateTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Quiniela;

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

        // Check if games belongs to quiniela
        if (
            array_diff(
                $quiniela->games->pluck('id'),
                collect($request->picks)->pluck('id')
            )
        ) {
            abort(400, 'Game/s dont belong to quiniela');
        }

        $ticket = $quiniela->tickets()->create([
            'user_id' => $request->user_id,
            'created_by' => auth()->user()->id,
            'price' => $quiniela->ticket_price,
        ]);

        $ticket->picks()->createMany($request->picks);

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

        $ticket->update($request->validated());

        return new TicketResource($ticket);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Quiniela $quiniela, Ticket $ticket)
    {
        $this->authorize('admin.ticket.destroy');

        $ticket->delete();

        return $this->noContent();
    }
}
