<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BalanceHistoryResource extends JsonResource
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
            'id'      =>  $this->id,
            'user_id' =>  $this->user_id,
            'prev_balance' =>  $this->prev_balance,
            'amount' =>  $this->amount,
            'new_balance' =>  $this->new_balance,
            'operation' =>  $this->operation,
            'concept' =>  $this->concept,
            'created_at' =>  $this->created_at->format('d-m-Y H:i'),
        ];
    }
}
