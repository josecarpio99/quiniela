<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Models\Transaction;
use App\Enums\TransactionTypeEnum;
use App\Enums\TransactionStatusEnum;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\TransactionResource;
use App\Actions\Withdraw\AdminStoreWithdrawAction;
use App\Http\Requests\Admin\StoreWithdrawRequest;
use App\Http\Requests\Admin\UpdateWithdrawRequest;
use Illuminate\Http\Request;

class WithdrawController extends ApiController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('withdraw.index');

        return TransactionResource::collection(
            Transaction::fromWithdrawals()->paginate(10)
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWithdrawRequest $request)
    {
        $this->authorize('withdraw.store');

        $user = User::find($request->user_id);

        $transaction = (new AdminStoreWithdrawAction())->execute($request, $user);

        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        $this->authorize('withdraw.show');

        return new TransactionResource($transaction);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWithdrawRequest $request, Transaction $transaction)
    {
        $this->authorize('withdraw.update');

        $transaction->update($request->except('update_user_balance'));

        return new TransactionResource($transaction);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Transaction $transaction)
    {
        $this->authorize('withdraw.destroy');

        $transaction->delete();

        return $this->noContent();
    }
}
