<?php

namespace App\Http\Controllers\Api\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Controllers\Api\ApiController;
use App\Http\Filters\UserSearchFilter;
use App\Http\Requests\Admin\StoreUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $this->authorize('user.index');

        $limit = $request->limit ?? $this->getDefaultPageLimit();;

        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::custom('search', new UserSearchFilter)
            ])
            ->allowedSorts(['username', 'email', 'created_at'])
            ->defaultSort('-created_at')
            ->allowedIncludes([
                'tickets', 'transactions', 'transactionsCreated', 'balanceHistory', 'deposits', 'withdrawals'
                ])
            ->where('id', '<>', auth()->user()->id);

        return UserResource::collection(($users->paginateData($limit)));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('user.store');

        $user = User::create($request->validated());

        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $this->authorize('user.show');

        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateUserRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('user.update');

        $user->update($request->validated());

        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $this->authorize('user.destroy');

        $user->delete();

        return $this->noContent();
    }
}
