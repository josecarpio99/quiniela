<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Mail\NewDepositRequest;
use App\Enums\TransactionTypeEnum;
use Spatie\Permission\Models\Role;
use App\Enums\TransactionStatusEnum;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\StoreDepositRequest;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;

class DepositController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $deposits = Transaction::whereUser(auth()->user())
            ->fromDeposits()
            ->latest()
            ->paginate(10);

        return TransactionResource::collection($deposits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDepositRequest $request)
    {
        $transaction = auth()->user()->transactions()->create(
            $request->validated() +
            [
                'type' => TransactionTypeEnum::Deposit,
                'status' => TransactionStatusEnum::Pending
            ]
        );

        $adminUsers = Role::findByName('Super admin', 'web')->users;

        foreach ($adminUsers->pluck('email')->all() as $recipient) {
            Mail::to($recipient)->send(new NewDepositRequest($transaction));
        }

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
