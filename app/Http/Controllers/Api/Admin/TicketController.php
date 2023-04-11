<?php

namespace App\Http\Controllers\Api\Admin;

use App\Actions\Ticket\AdminStoreTicketAction;
use App\Models\Pick;
use App\Models\User;
use App\Models\Ticket;
use App\Models\Quiniela;
use App\Http\Resources\TicketResource;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\StoreTicketRequest;
use App\Http\Requests\Admin\UpdateTicketRequest;
use App\Http\Requests\Admin\DestroyTicketRequest;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class TicketController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, Quiniela $quiniela)
    {
        $this->authorize('ticket.index');

        $limit = $request->limit ?? $this->getDefaultPageLimit();;

        $tickets = QueryBuilder::for(Ticket::class)
            ->allowedFilters([
                'user_id',
                'created_by'
            ])
            ->allowedSorts(['created_at', 'earned', 'position'])
            ->defaultSorts(['position', '-created_at'])
            ->allowedIncludes([
                'user',
                'creator',
                'picks'
            ])
            ->where('quiniela_id', $quiniela->id);

        return TicketResource::collection(($tickets->paginate($limit)))
            ->additional(['meta' => [
                'freeTicketsCount' => $quiniela->tickets()->freeCount(),
                'paidTicketsCount' => $quiniela->tickets()->paidCount()
            ]]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request, Quiniela $quiniela)
    {
        $this->authorize('store', [Ticket::class, $quiniela, true]);

        $user = User::find($request->user_id);

        $ticket = (new AdminStoreTicketAction)->execute($request, $user, $quiniela);

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

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Quiniela $quiniela, Ticket $ticket)
    {
        $this->authorize('destroy', $ticket);

        $ticket->delete();

        return $this->noContent();
    }
}
