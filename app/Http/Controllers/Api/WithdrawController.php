<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\StoreWithdrawRequest;

class WithdrawController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $withdraws = Transaction::whereUser(auth()->user())
            ->fromWithdraws()
            ->orderBy('created_at', 'DESC')
            ->paginate(10);

        return TransactionResource::collection($withdraws);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request)
    {
        $transaction = auth()->user()->transactions()->create(
            $request->validated() +
            [
                'type' => TransactionTypeEnum::Withdraw->value,
                'status' => TransactionStatusEnum::Pending->value
            ]
        );

        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('show', $transaction);

        return new TransactionResource($transaction);
    }
}
