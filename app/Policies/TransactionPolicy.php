<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class TransactionPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function show(User $user, Transaction $transaction): bool
    {
        if ($transaction->isDeposit() && $user->can('deposit.show')) {
            return true;
        }

        if ($transaction->isWithdraw() && $user->can('withdraw.show')) {
            return true;
        }

        return $user->id === $transaction->user_id;
    }
}
