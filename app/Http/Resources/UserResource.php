<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id'       =>  $this->id,
            'username' =>  $this->username,
            'email'    =>  $this->email,
            'balance'  =>  $this->balance,
            'tickets'  =>  TicketResource::collection($this->whenLoaded('tickets')),
            'transactions' =>  TransactionResource::collection($this->whenLoaded('transactions')),
            'transactionsCreated' =>  TransactionResource::collection($this->whenLoaded('transactionsCreated')),
            'balanceHistory' =>  BalanceHistoryResource::collection($this->whenLoaded('balanceHistory'))

        ];
    }
}
