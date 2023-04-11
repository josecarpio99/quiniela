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
            'position' => $this->position,
            'earned' => $this->earned,
            'created_at' => $this->created_at->format('d-m-Y H:i'),
            'picks' => PickResource::collection($this->whenLoaded('picks')),
            'user' => new UserResource($this->whenLoaded('user')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'quiniela' => $request->quiniela
        ];
    }
}
