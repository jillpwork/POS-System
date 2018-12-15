<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Expense extends JsonResource
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
            'id' => $this->id,
            'expense_description' => $this->expense_description,
            'amount' => $this->amount,
            'expense_date' => $this->expense_date,
            'display_date' => date('D d M Y', strtotime($this->expense_date)),
            'updated_at' => $this->updated_at->format('d-m-Y'),
            'created_at' => $this->created_at->format('d-m-Y'),
        ];
    }
}
