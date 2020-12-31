<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'number',
        'customer_id',
        'inspector_id',
        'engineer_id',
        'device_id',
        'date_contract',
        'deadline',
        'urgency',
        'defect',
        'equipment',
        'condition',
        'prepayment',
        'agreed_price',
        'total_price',
        'order_comment',
        'last_history_id',
    ];

    public function customer() 
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function device()
    {
        return $this->belongsTo(Device::class, 'device_id');
    }

    // public function userCreatedOrder() 
    // {
    //     return $this->belongsTo(User::class, 'inspector_id');
    // }

    // public function userRepairOrder() 
    // {
    //     return $this->belongsTo(User::class, 'engineer_id');
    // }

    public function orderHistory()
    {
        return $this->hasMany(OrderHistory::class, 'order_id');
    }

    public function lastHistory()
    {
        return $this->belongsTo(OrderHistory::class, 'last_history_id');
    }

    public function repairPart()
    {
        return $this->hasMany(RepairPart::class, 'order_id');
    }

    public function service()
    {
        return $this->hasMany(Service::class, 'order_id');
    }

    public function getDefects()
    {
        $defects_id = explode(',', $this->defect);
        $defects = Defect::whereIn('id', $defects_id)->get(['id', 'name']);
        return $defects;
    }

    public function getEquipments()
    {
        $equipments_id = explode(',', $this->equipment);
        $equipments = Equipment::whereIn('id', $equipments_id)->get(['id', 'name']);
        return $equipments;
    }

    public function getConditions()
    {
        $conditions_id = explode(',', $this->condition);
        $conditions = Condition::whereIn('id', $conditions_id)->get(['id', 'name']);
        return $conditions;
    }
}
 
