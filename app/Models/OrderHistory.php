<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderHistory extends Model
{
    protected $fillable = [
        'order_id',
        'user_id',
        'status_id',
    ];

    public function order() 
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function orderStatus() 
    {
        return $this->belongsTo(OrderStatus::class, 'status_id');
    }
}
