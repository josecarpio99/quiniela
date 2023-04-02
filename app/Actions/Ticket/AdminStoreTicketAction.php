<?php

namespace App\Actions\Ticket;

use App\Models\User;
use App\Models\Ticket;
use App\Models\Quiniela;
use Illuminate\Http\Request;
use App\Exceptions\InsufficientUserBalanceException;
use App\Exceptions\GamesDoNotBelongToQuinielaException;

class AdminStoreTicketAction
{
    public function execute(Request $request, User $user, Quiniela $quiniela) : Ticket
    {
        $isFree = false;

        if ($quiniela->has_three_for_two) {
            $isFree = $user->nextTicketIsFree($quiniela);
        }

        if (! $isFree) {
            throw_if(! $user->hasEnoughBalance($quiniela->ticket_price), InsufficientUserBalanceException::class);
        }

        throw_if(! $quiniela->gamesMatch(collect($request->picks)->pluck('game_id')->all()), GamesDoNotBelongToQuinielaException::class);

        $ticket = $quiniela->tickets()->create([
            'user_id' => $request->user_id,
            'created_by' => auth()->user()->id,
            'price' => $isFree ? 0 : $quiniela->ticket_price
        ]);

        $ticket->picks()->createMany($request->picks);

        if (! $isFree) {
            $user->decrement('balance', $quiniela->ticket_price);
        }

        return $ticket;
    }
}
