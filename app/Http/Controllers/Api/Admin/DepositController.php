<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\Admin\StoreDepositRequest;
use App\Http\Requests\Admin\UpdateDepositRequest;
use App\Http\Requests\Admin\DestroyDepositRequest;

class DepositController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('deposit.index');

        return TransactionResource::collection(
            Transaction::fromDeposits()->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepositRequest $request)
    {
        $this->authorize('deposit.store');

        $transaction = auth()->user()->transactionsCreated()->create(
            $request->except('update_user_balance') +
            [
                'type' => TransactionTypeEnum::Deposit,
                'status' => TransactionStatusEnum::Approved
            ]
        );

        if ($request->update_user_balance) {
            $transaction->user->increment('balance', $request->amount);
        }

        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('deposit.show');

        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositRequest $request, Transaction $transaction)
    {
        $this->authorize('deposit.update');

        $transaction->update($request->except('update_user_balance'));

        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $this->authorize('deposit.destroy');

        $transaction->delete();

        return $this->noContent();
    }
}
