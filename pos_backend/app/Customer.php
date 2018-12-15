<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    // Customer Has Many orders
    public function orders()
    {
        return $this->hasMany('App\Order');
    }
    
    // Customer has only one Mesurment
    public function Mesurment()
    {
        return $this->hasOne('App\Mesurment');
    }
}
