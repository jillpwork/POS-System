<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderImage extends Model
{
    // Order Images belongs to order
    protected $fillable = array('image_path', 'order_id');
    
    public function Order()
    {	

        return $this->belongsTo('App\Order');
    }
}
