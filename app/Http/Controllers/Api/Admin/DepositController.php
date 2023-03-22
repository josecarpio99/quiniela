<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Http\Requests\Admin\StoreDepositRequest;
use App\Http\Requests\Admin\UpdateDepositRequest;

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
    public function store(StoreDepositRequest $request, User $user)
    {
        $this->authorize('admin.deposit.store');

        $transaction = auth()->user()->transactionsCreated()->create(
            $request->except('update_user_balance') +
            [
                'user_id' => $user->id,
                'type' => TransactionTypeEnum::Deposit->value,
                'status' => TransactionStatusEnum::Approved->value
            ]
        );

        if ($request->update_user_balance) {
            $transaction->user()->increment('balance', $request->amount);
        }

        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Transaction $transaction)
    {
        $this->authorize('admin.deposit.show');

        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDepositRequest $request, User $user, Transaction $transaction)
    {
        $this->authorize('admin.deposit.update');

        $prevTransaction = $transaction->replicate();
        $transaction->update($request->except('update_user_balance'));

        if ($request->update_user_balance) {
            $newBalance = ( $transaction->user->balance - $prevTransaction->amount ) + $transaction->amount;
            $transaction->user()->update(['balance' => $newBalance]);
        }

        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $user, Transaction $transaction)
    {
        $this->authorize('admin.deposit.destroy');

        $validator = Validator::make($request->all(), [
            'update_user_balance' => ['required', 'boolean']
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()], 422);
        }

        if ($request->update_user_balance) {
            $transaction->user()->decrement('balance', $transaction->amount);
        }

        $transaction->delete();

        return $this->noContent();
    }
}
