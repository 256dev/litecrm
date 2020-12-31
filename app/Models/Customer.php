<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'email',
        'address',
        'status',
        'comment_about',
        // 'ads_campaign',
    ];

    public function phone()
    {
        return $this->hasMany(CustomerPhone::class, 'customer_id');
    }
    
    public function order()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
