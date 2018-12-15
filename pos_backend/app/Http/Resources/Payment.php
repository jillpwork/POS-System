<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Payment extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);
        return [
            "id" => $this->id,
            "payment_type" => $this->payment_type,
            "payment_ref_num" => $this->payment_ref_num,
            "payment_amount" => $this->payment_amount,
            "created_at" => $this->created_at->format('D d M Y'),
            "updated_at" => $this->updated_at->format('d-m-Y'),
            ];
    }
}
