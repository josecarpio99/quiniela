<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Enums\BalanceHistoryOperationEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Actions\User\UpdateUserBalanceAction;
use App\Http\Requests\Admin\ChangeDepositStatusRequest;

class ChangeDepositStatusController extends ApiController
{

    public function __invoke(ChangeDepositStatusRequest $request, Transaction $transaction)
    {
        $this->authorize('deposit.change_status');

        $prevStatus = $transaction->status;

        $transaction->update(['status' => $request->status]);

        if ($request->update_user_balance) {

            if ($request->status === TransactionStatusEnum::Approved->value) {

                (new UpdateUserBalanceAction())->execute(
                    $transaction->user,
                    $transaction->amount,
                    BalanceHistoryOperationEnum::Increment->value,
                    'Deposit #' . $transaction->id
                );

            }

        }

        return new TransactionResource($transaction);
    }
}
