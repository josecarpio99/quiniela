<?php

namespace App\Actions\Ticket;

use App\Models\Quiniela;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;

class AdminStoreTicketAction
{
    public function execute(Request $request, User $user, Quiniela $quiniela) : Ticket
    {
        throw_if(! $user->hasEnoughBalance($quiniela->ticket_price), InsufficientUserBalanceException::class);
        throw_if(! $quiniela->gamesMatch(collect($request->picks)->pluck('game_id')->all()), GamesDoNotBelongToQuinielaException::class);

        $ticket = $quiniela->tickets()->create([
            'user_id' => $request->user_id,
            'created_by' => auth()->user()->id,
            'price' => $quiniela->ticket_price,
        ]);

        $ticket->picks()->createMany($request->picks);

        $user->decrement('balance', $quiniela->ticket_price);

        return $ticket;
    }
}
