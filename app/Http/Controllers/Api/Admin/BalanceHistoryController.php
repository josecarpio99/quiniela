<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Resources\BalanceHistoryResource;
use App\Models\BalanceHistory;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;

class BalanceHistoryController extends ApiController
{
    public function __invoke(Request $request, User $user)
    {
        $this->authorize('balance_history.index');

        $limit = $request->limit ?? $this->getDefaultPageLimit();

        $history = QueryBuilder::for(BalanceHistory::class)
            ->defaultSort('-created_at')
            ->where('user_id', $user->id);

        return BalanceHistoryResource::collection($history->paginate($limit));
    }
}
