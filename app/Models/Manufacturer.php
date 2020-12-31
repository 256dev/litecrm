<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Manufacturer extends Model
{
    public $timestamps = false;

    protected $fillable = ['name', 'main', 'priority', 'comment'];

    public function deviceModel()
    {
        return $this->hasMany(DeviceModel::class, 'manufacturer_id');
    }
}
