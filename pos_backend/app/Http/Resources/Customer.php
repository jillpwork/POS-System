<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
// use App\Http\Resources\Mesurment as CustomerResource;

class Customer extends JsonResource
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
            'fullname' => $this->fullname,
            'date_of_birth' => date('Y-m-d', strtotime($this->date_of_birth)),
            'gender' => $this->gender,
            'email' => $this->email,
            'phone_number' => (string)$this->phone_number,
            'mobile' => (string)$this->mobile,
            'address_street' => $this->address_street,
            'city' => $this->city,
            'country' => $this->country,
            'postalcode' => $this->postalcode,
            'created_at' => $this->updated_at->format('d-m-Y'),
            'updated_at' => $this->created_at->format('d-m-Y'),
            'mesurment' => $this->mesurment,
        ];
    }
}