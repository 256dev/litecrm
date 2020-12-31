<?php

namespace App\Http\Controllers\CRM;

use App\Models\Order;
use App\Models\Device;
use App\Models\Customer;
use App\Models\DeviceModel;
use App\Models\TypeService;
use App\Models\CustomerPhone;
use App\Models\RepairPart;
use App\Models\Service;
use App\Models\TypeRepairPart;
use Date;
use Illuminate\Http\Request;

class GetInfoController extends CrmBaseController
{
    public function getCustomerInfo(Request $request)
    {   
        $id   = (int)$request->input('id');
        $data = Customer::where('id', $id)
                        ->select([
                            'id',
                            'name',
                            'email',
                            'comment_about AS comment',
                            'status AS status_info',
                        ])
                        ->get()
                        ->first();
        if (!$data) {
            return response()->json(['status' => 2]);
        }
        $data->route = route('customers.show', $data->id);
        $data->phones = CustomerPhone::where('customer_id', $id)->get();
        $data->orders = Order::where('orders.customer_id', $id)
                             ->join('devices', 'orders.device_id','devices.id')
                             ->join('device_models', 'devices.device_model_id', 'device_models.id')
                             ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                             ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                             ->join('order_histories', 'orders.last_history_id','order_histories.id')
                             ->join('order_statuses', 'order_histories.status_id', 'order_statuses.id')
                             ->select([
                                    'orders.id            AS id',
                                    'type_devices.name    AS type',
                                    'manufacturers.name   AS manufacturer',
                                    'device_models.name   AS model',
                                    'orders.defect        AS defect',
                                    'order_statuses.name  AS status',
                                    'order_statuses.color AS color',
                                    'orders.date_contract AS date',
                                ])
                             ->get();
        foreach ($data->orders as $order) {
            $order->date    = Date::parse($order->date)->tz(config('custom.tz'))->format('j F Y в H:i');
            $order->defects = $order->getDefects();
        }
        $data->status = 1;
        return response()->json($data);
    }

    public function getDeviceInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = Order::where('orders.id', $id)
                     ->join('devices', 'orders.device_id','devices.id')
                     ->join('device_models', 'devices.device_model_id', 'device_models.id')
                     ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                     ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                     ->select([
                        'type_devices.id    AS typeId',
                        'type_devices.name  AS typeName',
                        'manufacturers.id   AS manufacturerId',
                        'manufacturers.name AS manufacturerName',
                        'devices.SN         AS sn',
                        'devices.id         AS id',
                        'device_models.name AS modelName',
                        'device_models.id   AS modelId',
                        'orders.defect      AS defect',
                        'orders.equipment   AS equipment',
                        'orders.condition   AS condition',
                     ])
                     ->get()
                     ->first();
        if (!$data) {
            return response()->json(['status' => 2]);
        }
        $data->defects    = $data->getDefects();
        $data->equipments = $data->getEquipments();
        $data->conditions = $data->getConditions();
        $data->status = 1;

        return response()->json($data);
    }

    public function getSNInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = Device::where('devices.id', $id)
                      ->join('device_models', 'devices.device_model_id', 'device_models.id')
                      ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                      ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                      ->select([
                            'type_devices.id    AS typeId',
                            'type_devices.name  AS typeName',
                            'manufacturers.id   AS manufacturerId',
                            'manufacturers.name AS manufacturerName',
                            'device_models.id   AS modelId',
                            'device_models.name AS modelName',
                      ])
                      ->get()
                      ->first();
        return response()->json($data);
    }

    public function getModelInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = DeviceModel::where('device_models.id', $id)
                           ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                           ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                           ->select([
                            'type_devices.id    AS typeId',
                            'type_devices.name  AS typeName',
                            'manufacturers.id   AS manufacturerId',
                            'manufacturers.name AS manufacturerName',
                           ])
                           ->get()
                           ->first();
        return response()->json($data);
    }

    public function getTypeServiceInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = TypeService::find($id);

        return response()->json($data);
    }

    public function getServiceInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = Service::where('services.id', $id)
                        ->join('type_services', 'services.type_service_id', 'type_services.id')
                        ->select([
                            'type_services.name        AS name',
                            'type_services.description AS description',
                            'services.quantity         AS quantity',
                            'services.price            AS price',
                            'services.id               AS id',
                        ])
                        ->get()
                        ->first();
        return response()->json($data);
    }

    public function getTypeRepairPartInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = TypeRepairPart::find($id);
        
        return response()->json($data);
    }

    public function getRepairPartInfo(Request $request)
    {
        $id   = (int)$request->input('id');
        $data = RepairPart::where('repair_parts.id', $id)
                        ->join('type_repair_parts', 'repair_parts.type_repairparts_id', 'type_repair_parts.id')
                        ->select([
                            'type_repair_parts.name        AS name',
                            'type_repair_parts.description AS description',
                            'repair_parts.quantity         AS quantity',
                            'repair_parts.price            AS price',
                            'repair_parts.id               AS id',
                        ])
                        ->get()
                        ->first();
        return response()->json($data);
    }
}
