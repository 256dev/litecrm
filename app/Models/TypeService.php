<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeService extends Model
{
    public $timestamps = false;

    protected $fillable = [ 'name', 'price', 'main' , 'priority', 'description', 'comment'];

    public function service()
    {
        return $this->hasMany(Service::class, 'type_service_id');
    }
}
