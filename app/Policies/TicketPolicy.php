<?php

namespace App\Policies;

use App\Models\Quiniela;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TicketPolicy
{
    /**
     * Determine whether the user can view model.
     */
    public function show(User $user, Ticket $ticket): bool
    {
        return $user->can('ticket.show') || $user->id === $ticket->user_id;
    }

    /**
     * Determine whether the user can store models.
     */
    public function store(User $user, Quiniela $quiniela): bool
    {
        if (! $quiniela->is_active || now()->gt($quiniela->close_at)) {
            return false;
        }

        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        if (! $ticket->quiniela->is_active || now()->gt($ticket->quiniela->close_at)) {
            return false;
        }

        if ($user->can('ticket.create')) {
            return true;
        }

        if ($ticket->user_id === $user->id) {
            return true;
        }

        return false;
    }
}
