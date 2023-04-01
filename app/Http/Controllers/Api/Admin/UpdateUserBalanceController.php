<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Enums\BalanceHistoryOperationEnum;
use App\Exceptions\InsufficientUserBalanceException;
use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Admin\UpdateUserBalanceRequest;
use App\Http\Resources\UserResource;

class UpdateUserBalanceController extends ApiController
{
    public function __invoke(UpdateUserBalanceRequest $request, User $user)
    {
        $prevUser = $user->replicate();

        if ($request->operation === BalanceHistoryOperationEnum::Decrement->value) {
            throw_if(! $user->hasEnoughBalance($request->amount), InsufficientUserBalanceException::class);
            $user->decrement('balance', $request->amount);
        } else {
            $user->increment('balance', $request->amount);
        }

        $user->balanceHistory()->create([
            'prev_balance' => $prevUser->balance,
            'new_balance' => $user->balance,
            'amount' => $request->amount,
            'operation' => $request->operation,
            'concept' => $request->concept
        ]);

        return new UserResource($user);
    }
}
