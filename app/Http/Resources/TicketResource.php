<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TicketResource extends JsonResource
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
            'id' =>  $this->id,
            'user_id' =>  $this->user_id,
            'created_by' =>  $this->created_by,
            'quiniela_id' =>  $this->quiniela_id,
            'price' => $this->price,
            'points' => $this->points,
            'picks' => PickResource::collection($this->picks)
        ];
    }
}