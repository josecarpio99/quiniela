<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Transaction;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\ChangeWithdrawStatusRequest;
use App\Http\Resources\TransactionResource;

class ChangeWithdrawStatusController extends ApiController
{

    public function __invoke(ChangeWithdrawStatusRequest $request, Transaction $transaction)
    {
        $this->authorize('withdraw.change_status');

        if ($request->status === TransactionStatusEnum::Approved->value) {
            if ($transaction->user->balance < $transaction->amount) {
                return $this->error('User insufficient funds');
            }
        }

        $prevStatus = $transaction->status;

        $transaction->update(['status' => $request->status]);

        if ($request->update_user_balance) {
            if ($request->status === TransactionStatusEnum::Approved->value) {
                $transaction->user()->decrement('balance', $transaction->amount);
            }

            if ($prevStatus === TransactionStatusEnum::Approved->value) {
                $transaction->user()->increment('balance', $transaction->amount);
            }
        }

        return new TransactionResource($transaction);
    }
}
