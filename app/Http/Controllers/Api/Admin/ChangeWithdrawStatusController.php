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

        $prevStatus = $transaction->status;

        $transaction->update(['status' => $request->status]);

        return new TransactionResource($transaction);
    }
}
