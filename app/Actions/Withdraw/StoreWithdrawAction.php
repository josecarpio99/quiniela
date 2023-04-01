<?php

namespace App\Actions\Withdraw;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Enums\BalanceHistoryOperationEnum;
use App\Actions\User\UpdateUserBalanceAction;
use App\Exceptions\InsufficientUserBalanceException;
use App\Exceptions\UserExceededWithdrawDailyLimitException;

class StoreWithdrawAction
{
    public function execute(Request $request, User $user) : Transaction
    {
        throw_if(! $user->hasEnoughBalance($request->amount), InsufficientUserBalanceException::class);
        throw_if($user->hasExceededWithdrawDailyLimit(), UserExceededWithdrawDailyLimitException::class);

        $transaction = $user->transactions()->create(
            $request->validated() +
            [
                'type' => TransactionTypeEnum::Withdraw,
                'status' => TransactionStatusEnum::Pending
            ]
        );

        (new UpdateUserBalanceAction())->execute(
            $user,
            $transaction->amount,
            BalanceHistoryOperationEnum::Decrement->value,
            'Withdraw #' . $transaction->id
        );

        // TODO: Notify withdraw to admin...

        return $transaction;
    }
}
