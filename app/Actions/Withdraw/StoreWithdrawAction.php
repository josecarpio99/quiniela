<?php

namespace App\Actions\Withdraw;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Exceptions\InsufficientUserBalanceException;
use App\Exceptions\UserExceededWithdrawDailyLimitException;

class StoreWithdrawAction
{
    public function execute(Request $request, User $user) : Transaction
    {
        throw_if(! $user->canWithdrawAmount($request->amount), InsufficientUserBalanceException::class);
        throw_if($user->hasExceededWithdrawDailyLimit(), UserExceededWithdrawDailyLimitException::class);

        $transaction = $user->transactions()->create(
            $request->validated() +
            [
                'type' => TransactionTypeEnum::Withdraw,
                'status' => auth()->user()->id === $user->id ? TransactionStatusEnum::Pending : TransactionStatusEnum::Approved,
                'created_by' => auth()->user()->id === $user->id ? NULL : auth()->user()->id
            ]
        );

        $user->decrement('balance', $transaction->amount);

        if (auth()->user()->id === $user->id) {
            // TODO: Notify withdraw to admin...
        }

        return $transaction;
    }
}
