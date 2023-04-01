<?php

namespace App\Actions\User;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\BalanceHistoryOperationEnum;

class UpdateUserBalanceAction
{
    public function execute(User $user, int|float $amount, string $operation, ?string $concept) : User
    {
        $prevUser = $user->replicate();

        if ($operation === BalanceHistoryOperationEnum::Decrement->value) {
            $user->decrement('balance', $amount);
        } else {
            $user->increment('balance', $amount);
        }

        $user->balanceHistory()->create([
            'prev_balance' => $prevUser->balance,
            'new_balance' => $user->balance,
            'amount' => $amount,
            'operation' => $operation,
            'concept' => $concept
        ]);

        return $user;
    }
}
