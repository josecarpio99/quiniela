<?php

namespace App\Http\Controllers\Api;

use App\Models\Transaction;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\StoreWithdrawRequest;
use App\Http\Resources\TransactionResource;
use App\Actions\Withdraw\StoreWithdrawAction;
use Illuminate\Http\Request;

class WithdrawController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->limit ?? $this->getDefaultPageLimit();

        $deposits = QueryBuilder::for(Transaction::class)
            ->allowedFilters([
                'user_id',
                'payment_method',
                'created_by',
                'status'
            ])
            ->allowedSorts(['date'])
            ->defaultSort('-date')
            ->allowedIncludes(['user', 'paymentMethod', 'creator'])
            ->where('user_id', auth()->user()->id)
            ->fromWithdrawals();

        return TransactionResource::collection($deposits->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request)
    {
        $transaction = (new StoreWithdrawAction())->execute($request, auth()->user());

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
