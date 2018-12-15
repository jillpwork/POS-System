<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    // Payment Has One Order
    public function Order()
    {
        return $this->belongsTo('App\Order');
    }
}
