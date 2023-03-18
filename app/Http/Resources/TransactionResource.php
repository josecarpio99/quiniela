<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' =>  $this->id,
            'user_id' =>  $this->user_id,
            'created_by' =>  $this->created_by,
            'type' =>  $this->type,
            'amount' =>  $this->amount,
            'payment_method' =>  $this->payment_method,
            'payment_reference' =>  $this->payment_reference,
            'status' =>  $this->status,
            'rejected_reason' =>  $this->rejected_reason,
            'date' =>  $this->date->format('Y-m-d'),
        ];
    }
}
