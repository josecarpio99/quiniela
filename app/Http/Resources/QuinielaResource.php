<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class QuinielaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'ticket_price' => $this->ticket_price,
            'is_active' => $this->is_active,
            'close_at' => $this->close_at->format('Y-m-d H:i'),
            'prize'   => $this->prize,
            'games'  =>  TicketResource::collection($this->whenLoaded('games')),
            'tickets'  =>  TicketResource::collection($this->whenLoaded('tickets'))
        ];
    }
}
