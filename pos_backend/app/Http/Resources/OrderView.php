<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\Customer as CustomerResource;
use App\Http\Resources\OrderItem as OrderItemResource;

class OrderView extends JsonResource
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
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'customer' => new CustomerResource($this->customer),
            'order_number' => $this->order_number,
            'discount' => $this->discount,
            'sgst' => $this->sgst,
            'cgst' => $this->cgst,
            'igst' => $this->igst,
            'other_charges' => $this->other_charges,
            'total_amount' => $this->total_amount,
            'paid_amount' => $this->paid_amount,
            'paid_status' => $this->paid_status,
            'extra_notes' => $this->extra_notes,
            'order_date' => $this->order_date,
            'order_date_n_day' => date('D d M Y', strtotime($this->order_date)),
            'order_delivery_date' => $this->order_delivery_date,
            'order_items' => OrderItemResource::collection($this->orderItem),
            'order_images' => $this->orderImage,
            'created_at' => $this->updated_at->format('d-m-Y'),
            'updated_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
