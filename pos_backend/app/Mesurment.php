<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesurment extends Model
{
    // Order Has One Customer
    public function Customer()
    {
        return $this->belongsTo('App\Customer');
    }
}
