<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\ChangeDepositStatusRequest;
use App\Http\Resources\TransactionResource;

class ChangeDepositStatusController extends ApiController
{

    public function __invoke(ChangeDepositStatusRequest $request, Transaction $transaction)
    {
        $this->authorize('admin.deposit.change_status');

        $prevStatus = $transaction->status;

        $transaction->update(['status' => $request->status]);

        if ($request->update_user_balance) {
            if ($request->status === TransactionStatusEnum::Approved->value) {
                $transaction->user()->increment('balance', $transaction->amount);
            }

            if ($prevStatus === TransactionStatusEnum::Approved->value) {
                $transaction->user()->decrement('balance', $transaction->amount);
            }
        }

        return new TransactionResource($transaction);
    }
}
