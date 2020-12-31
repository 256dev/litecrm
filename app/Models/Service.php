<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type_service_id',
        'order_id',
        'quantity',
        'price',
    ];

    public function typeService()
    {
        return $this->belongsTo(TypeService::class, 'type_service_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
