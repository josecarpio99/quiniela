<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Transaction;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\StoreDepositRequest;
use App\Http\Requests\Admin\UpdateDepositRequest;
use App\Http\Resources\TransactionResource;

class DepositController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('admin.deposit.index');

        return TransactionResource::collection(
            Transaction::where('type', TransactionTypeEnum::Deposit->value)->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepositRequest $request)
    {
        $this->authorize('admin.deposit.store');

        $transaction = auth()->user()->transactionsCreated()->create(
            $request->validated() +
            [
                'type' => TransactionTypeEnum::Deposit->value,
                'status' => TransactionStatusEnum::Approved->value
            ]
        );

        $transaction->user()->increment('balance', $request->amount);

        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('admin.deposit.show');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositRequest $request, Transaction $transaction)
    {
        $this->authorize('admin.deposit.update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('admin.deposit.destroy');
    }
}
