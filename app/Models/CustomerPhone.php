<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerPhone extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'customer_id',
        'phone',
        'telegram',
        'viber',
        'whatsapp',
    ];

    protected $primaryKey = [
        'customer_id',
        'phone',
    ];
    
    public $incrementing = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
