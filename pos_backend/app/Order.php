<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Order has only one customer
    public function Customer()
    {
        return $this->belongsTo('App\Customer');
    }

    // Order Has many items
    public function OrderItem()
    {
        return $this->hasMany('App\OrderItem');
    }

    // Order Has many Images
    public function OrderImage()
    {
        return $this->hasMany('App\OrderImage');
    }
}
