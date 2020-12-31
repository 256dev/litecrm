<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    public $timestamps = false;
    
    protected $fillable = [
        'device_model_id',
        'SN',
        'comment',
    ];

    public function order()
    {
        return $this->hasMany(Order::class, 'device_id');
    }

    public function deviceModel()
    {
        return $this->belongsTo(DeviceModel::class, 'device_model_id');
    }
}
