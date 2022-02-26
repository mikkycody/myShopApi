<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'id' => $this->id,
            'reference' => $this->reference,
            'total' => $this->total,
            'user_id' => $this->user_id,
            'items' => OrderItemResource::collection($this->items),
            'status' => $this->status,
            'created_at' => $this->created_at,
        ];
    }
}
