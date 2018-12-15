<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderItem extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "item_name" => $this->item_name,
            "quantity" => $this->quantity,
            "extra_notes" => $this->extra_notes,
            "price" => $this->price,
            "total" => $this->total,
        ];
    }
}
