<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Actions\User\UpdateUserBalanceAction;
use App\Enums\BalanceHistoryOperationEnum;
use App\Http\Requests\Admin\StoreDepositRequest;
use App\Http\Requests\Admin\UpdateDepositRequest;
use App\Http\Requests\Admin\DestroyDepositRequest;
use Spatie\QueryBuilder\QueryBuilder;

class DepositController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $this->authorize('deposit.index');

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
            ->fromDeposits();

        return TransactionResource::collection($deposits->paginate($limit));
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
            (new UpdateUserBalanceAction())->execute(
                $transaction->user,
                $request->amount,
                BalanceHistoryOperationEnum::Increment->value,
                'Deposit #' . $transaction->id
            );
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
