<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeviceModel extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'manufacturer_id',
        'type_device_id',
        'comment',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(Manufacturer::class, 'manufacturer_id');
    }

    public function typeDevice()
    {
        return $this->belongsTo(TypeDevice::class, 'type_device_id');
    }

    public function device()
    {
        return $this->hasMany(Device::class, 'device_model_id');
    }
}
