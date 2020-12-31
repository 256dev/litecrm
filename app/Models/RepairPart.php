<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RepairPart extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'type_repairparts_id',
        'order_id',
        'quantity',
        'price',
        'selfpart',
    ];

    public function typeRepairPart()
    {
        return $this->belongsTo(TypeRepairPart::class, 'type_repairparts_id');
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
