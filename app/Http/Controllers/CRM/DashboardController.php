<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $orders = Order::whereIn('order_statuses.id', [1,2,3,4])
                       ->join('devices', 'orders.device_id','devices.id')
                       ->join('device_models', 'devices.device_model_id', 'device_models.id')
                       ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                       ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                       ->join('order_histories', 'orders.last_history_id','order_histories.id')
                       ->join('order_statuses', 'order_histories.status_id', 'order_statuses.id')
                       ->join('customers', 'orders.customer_id', 'customers.id' )
                       ->select([
                           'orders.id            AS id',
                           'orders.number        AS number',
                           'devices.SN           AS sn',
                           'type_devices.name    AS type',
                           'manufacturers.name   AS manufacturer',
                           'device_models.name   AS model',
                           'orders.urgency       AS urgency',
                           'order_statuses.name  AS status',
                           'order_statuses.id    AS statusId',
                           'order_statuses.color AS color',
                           'orders.date_contract AS date',
                           'orders.total_price   AS price',
                           'orders.prepayment    AS prepayment',
                           'customers.id         AS customerId',
                           'customers.name       AS customerName',
                       ])
                       ->orderBy('orders.id', 'DESC')
                       ->get();
        $count = new Collection();
        $count->received = $orders->where('statusId', 1)->count();
        $count->in_work  = $orders->where('statusId', 2)->count();
        $count->on_pause = $orders->where('statusId', 3)->count();
        $count->ready    = $orders->where('statusId', 4)->count();
        return view('main', compact('orders', 'count'));  
    }
}
