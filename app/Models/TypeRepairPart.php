<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeRepairPart extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'price',
        'quantity',
        'infinity',
        'priority',
        'main',
        'sales',
        'selfpart',
        'description',
        'comment',
    ];

    public function repairPart()
    {
        return $this->hasMany(RepairPart::class, 'type_repairparts_id');
    }
}
