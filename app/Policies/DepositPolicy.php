<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class DepositPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Transaction $transaction): bool
    {
        return $user->can('deposit.show') || $user->id === $transaction->user_id;
    }
}
