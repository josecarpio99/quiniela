<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use App\Http\Resources\UserResource;
use App\Enums\BalanceHistoryOperationEnum;
use App\Http\Controllers\Api\ApiController;
use App\Actions\User\UpdateUserBalanceAction;
use App\Exceptions\InsufficientUserBalanceException;
use App\Http\Requests\Admin\UpdateUserBalanceRequest;

class UpdateUserBalanceController extends ApiController
{
    public function __invoke(UpdateUserBalanceRequest $request, User $user)
    {

        if ($request->operation === BalanceHistoryOperationEnum::Decrement->value) {
            throw_if(! $user->hasEnoughBalance($request->amount), InsufficientUserBalanceException::class);
        }

        $user = (new UpdateUserBalanceAction())->execute(
            $user,
            $request->amount,
            $request->operation,
            $request->concept
        );

        return new UserResource($user);
    }
}
