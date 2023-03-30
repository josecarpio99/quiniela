<?php

namespace App\Actions\Withdraw;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Exceptions\InsufficientUserBalanceException;
use App\Exceptions\UserExceededWithdrawDailyLimitException;

class AdminStoreWithdrawAction
{
    public function execute(Request $request, User $user) : Transaction
    {
        throw_if(! $user->hasEnoughAmount($request->amount), InsufficientUserBalanceException::class);
        throw_if($user->hasExceededWithdrawDailyLimit(), UserExceededWithdrawDailyLimitException::class);

        $transaction = $user->transactions()->create(
            $request->except('update_user_balance') +
            [
                'type' => TransactionTypeEnum::Withdraw,
                'status' => TransactionStatusEnum::Approved,
                'created_by' => auth()->user()->id
            ]
        );

        if ($request->update_user_balance) {
            $user->decrement('balance', $transaction->amount);
        }

        return $transaction;
    }
}
