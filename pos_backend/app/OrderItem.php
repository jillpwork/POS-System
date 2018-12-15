<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    // Order Items belongs to order
    protected $fillable = array('item_name', 'material', 'design', 'extra_notes', 'order_id');
    
    public function Order()
    {	

        return $this->belongsTo('App\Order');
    }
}
