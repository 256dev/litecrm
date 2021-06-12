<?php

namespace App\Http\Controllers\CRM;

use App\Models\User;
use App\Models\Order;
use App\Models\Device;
use App\Models\Service;
use App\Models\Customer;
use App\Models\RepairPart;
use App\Models\DeviceModel;
use App\Models\TypeService;
use App\Models\OrderHistory;
use App\Models\CustomerPhone;
use App\Models\TypeRepairPart;
use Illuminate\Http\Request;
use Date;
use Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class OrderController extends CrmBaseController
{
    public function __construct() {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        $orders = Order::join('devices', 'orders.device_id','devices.id')
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
                           'order_statuses.color AS color',
                           'orders.date_contract AS date',
                           'orders.total_price   AS price',
                           'orders.prepayment    AS prepayment',
                           'customers.id         AS customerId',
                           'customers.name       AS customerName',
                       ])
                       ->orderBy('orders.id', 'DESC')
                       ->get();
        return view('main.order.showAll', compact('orders'));  
    }

    public function show(Order $order)
    {
        $id = $order->id;
        if (!$id) {
            abort('404');
        }
        $order = Order::where('orders.id', $id)
                      ->join('users AS engineer', 'orders.engineer_id', 'engineer.id')
                      ->join('users AS inspector', 'orders.inspector_id', 'inspector.id')
                      ->join('devices', 'orders.device_id','devices.id')
                      ->join('device_models', 'devices.device_model_id', 'device_models.id')
                      ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                      ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                      ->join('order_histories', 'orders.last_history_id','order_histories.id')
                      ->join('order_statuses', 'order_histories.status_id', 'order_statuses.id')
                      ->select([
                        'orders.id                 AS id',
                        'orders.number             AS number',
                        'orders.customer_id        AS customer_id',
                        'orders.engineer_id        AS engineer_id',
                        'orders.inspector_id       AS inspector_id',
                        'engineer.name             AS engineer_name',
                        'inspector.name            AS inspector_name',
                        'orders.date_contract      AS date',
                        'orders.deadline           AS deadline',
                        'orders.urgency            AS urgency',
                        'orders.defect             AS defect',
                        'orders.equipment          AS equipment',
                        'orders.condition          AS condition',
                        'orders.agreed_price       AS agreed_price',
                        'orders.price_repair_parts AS price_repair_parts',
                        'orders.price_work         AS price_work',
                        'orders.total_price        AS total_price',
                        'orders.discount           AS discount',
                        'orders.prepayment         AS prepayment',
                        'orders.order_comment      AS order_comment',
                        'devices.SN                AS sn',
                        'type_devices.name         AS type',
                        'manufacturers.name        AS manufacturer',
                        'device_models.name        AS model',
                        'order_statuses.name       AS status',
                        'order_statuses.color      AS color',
                      ])
                      ->orderBy('orders.id', 'DESC')
                      ->get()
                      ->first();
        if (!$order) {
            abort('404');
        }
        $defects = $order->getDefects()->pluck('name');
        if ($defects) { 
            $order->defects = implode(', ', $defects->toArray());
        } else {
            $order->defects = '';
        }
        $conditions = $order->getConditions()->pluck('name');
        if ($conditions) { 
            $order->conditions = implode(', ', $conditions->toArray());
        } else {
            $order->conditions = '';
        }
        $equipments = $order->getEquipments()->pluck('name');
        if ($defects) { 
            $order->equipments = implode(', ', $equipments->toArray());
        } else {
            $order->equipments = '';
        }
        
        $services = $order->service()
                          ->join('type_services', 'services.type_service_id', 'type_services.id')
                          ->select([
                              'type_services.name AS name',
                              'services.id        AS id',
                              'services.price     AS price',
                              'services.quantity  AS quantity',
                          ])
                          ->get();
        $repairParts = $order->repairPart()
                             ->join('type_repair_parts', 'repair_parts.type_repairparts_id', 'type_repair_parts.id')
                             ->select([
                                'type_repair_parts.name     AS name',
                                'repair_parts.selfpart      AS selfpart',
                                'repair_parts.id            AS id',
                                'repair_parts.price         AS price',
                                'repair_parts.quantity      AS quantity',
                             ])
                             ->get();
        $customer = Customer::find((int)$order->customer_id);
        $customer->phones = $customer->phone;
        $statuses = $order->orderHistory()
                          ->join('order_statuses', 'order_histories.status_id', '=', 'order_statuses.id')
                          ->select([
                            'order_histories.created_at AS date',
                            'order_statuses.name       AS name',
                            'order_statuses.color      AS color',
                          ])
                          ->orderBy('created_at', 'DESC')
                          ->get();
        return view('main.order.show', compact('order', 'customer', 'statuses', 'services', 'repairParts'));
    }

    public function create($customer_id = 0)
    {
        $engineers     = User::all(['id', 'name']);
        if ($customer_id != 0) {
            $customer = Customer::find($customer_id);
            if (!$customer) {
                abort('404');
            }
            $customer->phones = CustomerPhone::where('customer_id', $customer_id)->get();
            $orders = Order::where('orders.customer_id', $customer_id)
                           ->join('devices', 'orders.device_id','devices.id')
                           ->join('device_models', 'devices.device_model_id', 'device_models.id')
                           ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                           ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                           ->join('order_histories', 'orders.last_history_id','order_histories.id')
                           ->join('order_statuses', 'order_histories.status_id', 'order_statuses.id')
                           ->select([
                               'orders.id            AS id',
                               'devices.SN           AS sn',
                               'type_devices.name    AS type',
                               'manufacturers.name   AS manufacturer',
                               'device_models.name   AS model',
                               'orders.defect        AS defect',
                               'order_statuses.name  AS status',
                               'order_statuses.color AS color',
                               'orders.date_contract AS date',
                               'orders.total_price   AS price'
                           ])
                           ->get();
            foreach ($orders as $order) {
                $defects = $order->getDefects()->pluck('name');
                if ($defects) { 
                    $order->defects = implode(', ', $defects->toArray());
                } else {
                    $order->defects = '';
                }
            }
            return view('main.order.addUpdate', compact('engineers', 'customer', 'orders'));
        } else {
            $customer = new Customer();
            return view('main.order.addUpdate', compact('engineers', 'customer'));
        }
    }

    public function store(Request $request)
    {
        if(!$request->ajax()){
            abort('404');          
        };

        if ($validator = $this->baseOrderValidator($request)) {
            return response()->json([
                'status'  => 2 ,
                'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                'errors'  => $validator->errors()
            ]);          
        }

        $customer_id     = (int)$request->customer;
        $inspector_id    = (int)Auth::user()->id;
        $engineer_id     = (int)$request->engineer;
        $agreed_price    = (float)$request->agreed_price;
        $prepayment      = (float)$request->prepayment;
        $date_contract   = Date::parse($request->date_contract . ' ' . $request->time_contract, config('custom.tz'))->tz('UTC')->format('Y-m-d H:i');
        $deadline        = (int)$request->deadline;   
        $urgency         = (int)($request->urgency == 1? 1 : 0);
        $order_comment   = (string)$request->order_comment;

        $unitcode = session('unitcode');
        $number   = $unitcode . Date::now()->tz(config('custom.tz'))->format('YmdHis');

        $manufacturer_id = $this->getId($request->manufacturer, 'Manufacturer');
        $typeDevice_id  = $this->getId($request->typedevice, 'TypeDevice');

        $model = strip_tags($request->model);
        if (preg_match('/^new_/', $model)) {
            $model = substr($model, 4);
            $item  = DeviceModel::where('name', $model)->get(['id']);
            if(!$item->count()) {
                $model_id = DeviceModel::create([
                    'name'            => $model,
                    'manufacturer_id' => $manufacturer_id,
                    'type_device_id'  => $typeDevice_id,
                ])->id;
            } else {
                $model_id = (int)$item->first()->id;
            }
        } else {
            $item = DeviceModel::find((int)$model);
            if (!$item) {
                return response()->json([
                    'status'  => 3,
                    'message' => ['Ошибка модели устройства!', 'danger']
                ]);
            }
            $model_id = (int)$model;
        }
        
        $sn = strip_tags($request->sn);
        if (preg_match('/^new_/', $sn)) {
            $sn    = substr($sn, 4);
            $item  = Device::where('sn', $sn)->get(['id']);
            if(!$item->count()) {
                $device_id = Device::create([
                    'SN'              => $sn,
                    'device_model_id' => $model_id,
                ])->id;
            } else {
                $device_id = (int)$item->first()->id;
            }
        } else {
            $item = Device::find((int)$sn);
            if (!$item) {
                return response()->json([
                    'status'  => 3,
                    'message' => ['Ошибка модели устройства!', 'danger']
                ]);
            }
            if ($item->device_model_id != $model_id) {
                $item->device_model_id = $model_id;
                $item->save();
            }
            $device_id = (int)$sn;
        }

        $conditions = $this->getAllId($request->conditions, 'Condition');
        $equipments = $this->getAllId($request->equipments, 'Equipment');
        $defects    = $this->getAllId($request->defects, 'Defect');

        try {
            $order = Order::create([
                    'number'        => $number,
                    'customer_id'   => $customer_id,
                    'engineer_id'   => $engineer_id,
                    'inspector_id'  => $inspector_id,
                    'device_id'     => $device_id,
                    'date_contract' => $date_contract,
                    'deadline'      => $deadline,
                    'urgency'       => $urgency,
                    'defect'        => $defects,
                    'equipment'     => $equipments,
                    'condition'     => $conditions,
                    'agreed_price'  => $agreed_price,
                    'prepayment'    => $prepayment,
                    'total_price'   => 0 - $prepayment,
                    'order_comment' => $order_comment,
            ]);
            $last_history_id = $order->orderHistory()->create([
                                    'user_id' => $order->inspector_id,
                                    'status_id' => 1,
                               ])->id;
            $order->update(['last_history_id' => $last_history_id]);
            $customer = $order->customer;
            $customer->orders_in_process += 1;
            $customer->all_orders        += 1;
            $customer->save();
        } catch (QueryException $e) {
            Log::info($e);
            return response()->json([
                'status'  => 3,
                'message' => ['Ошибка оформления заказа!', 'danger'],
                'error'   => $e
            ]);
        }
        return response()->json([
            'status'      => 1,
            'message'     => ['Заказ оформлен!', 'success'],
            'order_route' => route('orders.show', $order->id)
        ]);
    }

    public function edit(Order $order)
    {
        $order_id = $order->id;
        if (!$order_id) {
            abort('404');
        }
        $order = Order::where('orders.id', $order_id)
                      ->join('devices', 'orders.device_id','devices.id')
                      ->join('device_models', 'devices.device_model_id', 'device_models.id')
                      ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                      ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                      ->select([
                        'orders.id            AS id',
                        'orders.number        AS number',
                        'orders.date_contract AS date',
                        'orders.deadline      AS deadline',
                        'orders.urgency       AS urgency',
                        'orders.prepayment    AS prepayment',
                        'orders.agreed_price  AS agreedPrice',
                        'orders.engineer_id   AS engineerId',
                        'orders.customer_id   AS customerId',
                        'orders.order_comment AS comment',
                        'type_devices.id      AS typeId',
                        'type_devices.name    AS typeName',
                        'manufacturers.id     AS manufacturerId',
                        'manufacturers.name   AS manufacturerName',
                        'devices.SN           AS deviceSN',
                        'devices.id           AS deviceId',
                        'device_models.name   AS modelName',
                        'device_models.id     AS modelId',
                        'orders.defect        AS defect',
                        'orders.equipment     AS equipment',
                        'orders.condition     AS condition',
                      ])
                      ->get()
                      ->first();
        if (!$order) {
            abort('404');
        }
        $edit = 1;
        $order->defects    = $order->getDefects();
        $order->equipments = $order->getEquipments();
        $order->conditions = $order->getConditions();
        $engineers = User::all(['id', 'name']);
        return view('main.order.addUpdate', compact('edit', 'order', 'engineers'));
    }

    public function update(Request $request, Order $order)
    {
        if(!$request->ajax()){
            abort('404');          
        };
        if ($validator = $this->baseOrderValidator($request)) {
            return response()->json(['status' => 2 , 'message' => ['Неверно заполненные поля помечены красным', 'danger'],'errors' => $validator->errors()]);          
        }
        $order_id = $order->id;
        $order    = Order::where('id', $order_id)->get()->first();
        if ($order->count()) {
            $engineer_id       = (int)$request->engineer;
            $agreed_price      = (float)$request->agreed_price;
            $prepayment        = (float)$request->prepayment;
            $total_price       = $order->total_price + $order->prepayment - $prepayment;
            $date_contract     = Date::parse($request->date_contract . ' ' . $request->time_contract, config('custom.tz'))->tz('UTC')->format('Y-m-d H:i');
            $deadline          = (int)$request->deadline;   
            $urgency           = (int)($request->urgency == 1? 1 : 0);
            $order_comment     = (string)$request->order_comment;

            $manufacturer_id = $this->getId($request->manufacturer, 'Manufacturer');
            $typeDevice_id  = $this->getId($request->typedevice, 'TypeDevice');

            $model = strip_tags($request->model);
            if (preg_match('/^new_/', $model)) {
                $model = substr($model, 4);
                $item  = DeviceModel::where('name', $model)->get(['id']);
                if(!$item->count()) {
                    $model_id = DeviceModel::create([
                        'name'            => $model,
                        'manufacturer_id' => $manufacturer_id,
                        'type_device_id'  => $typeDevice_id,
                    ])->id;
                } else {
                    $model_id = (int)$item->first()->id;
                }
            } else {
                $item = DeviceModel::find((int)$model);
                if (!$item) {
                    return response()->json([
                        'status'  => 3,
                        'message' => ['Ошибка модели устройства!', 'danger']
                    ]);
                }
                $model_id = (int)$model;
            }
            
            $sn = strip_tags($request->sn);
            if (preg_match('/^new_/', $sn)) {
                $sn   = substr($sn, 4);
                $item = Device::where('sn', $sn)->get(['id']);
                if(!$item->count()) {
                    $device_id = Device::create([
                        'SN'              => $sn,
                        'device_model_id' => $model_id,
                    ])->id;
                } else {
                    $device_id = (int)$item->first()->id;
                }
            } else {
                $item = Device::find((int)$sn);
                if (!$item) {
                    return response()->json([
                        'status'  => 3,
                        'message' => ['Ошибка модели устройства!', 'danger']
                    ]);
                }
                if ($item->device_model_id != $model_id) {
                    $item->device_model_id = $model_id;
                    $item->save();
                }
                $device_id = (int)$sn;
            }
            
            $conditions = $this->getAllId($request->conditions, 'Condition');
            $equipments = $this->getAllId($request->equipments, 'Equipment');
            $defects    = $this->getAllId($request->defects, 'Defect');

            $order = $order->update([
                        'engineer_id'   => $engineer_id,
                        'device_id'     => $device_id,
                        'date_contract' => $date_contract,
                        'deadline'      => $deadline,
                        'urgency'       => $urgency,
                        'defect'        => $defects,
                        'equipment'     => $equipments,
                        'condition'     => $conditions,
                        'agreed_price'  => $agreed_price,
                        'prepayment'    => $prepayment,
                        'total_price'   => $total_price,
                        'order_comment' => $order_comment,
                     ]);

            if ($order) {
                return response()->json([
                    'status'      => 1,
                    'message'     => ['Данные заказа изменены', 'success'],
                    'order_route' => route('orders.show', $order_id)
                ]);
            }
        }
        return response()->json([
            'status'  => 3,
            'message' => ['Ошибка редактирования заказа!', 'danger']
        ]);
    }

    public function destroy(Order $order)
    {
        $id = $order->id;
        try {
            $order = Order::where('id', '=', $id)->get()->first();
            $old_status_id = $order->lastHistory->status_id;
            $customer = $order->customer;
            $order->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Заказ не может быть удален, к нему подключены услуги или материалы');
        }
        if (in_array($old_status_id, [1,2,3,4])) {
            $customer->orders_in_process -= 1;    
        }
        $customer->all_orders -= 1;
        $customer->save();

        return redirect()->route('orders.index')->with('message', 'Заказ удалён.');
    }

    public function addStatus(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $validator = Validator::make($request->all(), [
            'statusname' => 'exists:order_statuses,id',
            'comment'    => 'nullable|string|max:300',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 2 , 'message' => ['Неверно заполненные поля помечены красным', 'danger'], 'errors' => $validator->errors()]);          
        }

        $inspector_id = (int)Auth::user()->id;
        $order_id     = (int)$id;
        $status_id    = (int)$request->statusname;
        $comment      = strip_tags($request->commnet);

        try {
            $status = OrderHistory::create([
                'order_id'  => $order_id,
                'status_id' => $status_id ,
                'user_id'   => $inspector_id,
                'comment'   => $comment,
            ]);
            $id = $status->id;
            $status->date = Date::parse($status->created_at)->tz(config('custom.tz'))->format('j F Y в G:i');
            $order = Order::find($order_id);
            $old_status_id = $order->lastHistory->status_id;
            $order->update(['last_history_id' => $id]);
            $status = $status->orderStatus;
            $status->date = Date::parse($status->created_at)->tz(config('custom.tz'))->format('j F Y в G:i');
            if (in_array($old_status_id, [5,6]) && in_array($status_id, [1,2,3,4])) {
                $customer = $order->customer;
                $customer->orders_in_process += 1;
                $customer->save();    
            } elseif (in_array($old_status_id, [1,2,3,4]) && in_array($status_id, [5,6])) {
                $customer = $order->customer;
                $customer->orders_in_process -= 1;
                $customer->save();    
            } else {

            }
        } catch (QueryException $e) {
            return response()->json([
                'status'  => 3 ,
                'message' => ['Ошибка обновления статуса!', 'danger'],
                'error'   => $e
            ]);
        }
        return response()->json([
            'status'  => 1 ,
            'message' => ['Статус обновлен', 'success'],
            'info'    => $status
        ]);
    }

    public function addService(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $service = strip_tags($request->servicename);
        if (preg_match('/^new_/', $service)) {
            $service = substr($service, 4);
            $item    = TypeService::where('name', $service)->get(['id']);
            if (!$item->count()) {
                $validator = Validator::make($request->all(), [
                    'servicename' => 'required|max:50',
                    'price'       => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
                    'description' => 'nullable|string|max:200',
                    'quantity'    => 'required|numeric|min:1|max:5000',
                ]);
                if ($validator->fails()) {
                    return response()->json([
                        'status'  => 2 ,
                        'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                        'errors'  => $validator->errors()
                    ]);          
                }
                $service_id = TypeService::create([
                    'name'        => $service,
                    'price'       => $request->price,
                    'description' => $request->description,
                ])->id;
            } else {
                $service_id = (int)$item->first()->id;
            }
        } else {
            $service_id = (int)$service;
        }
        if ($service_id) {
            $data = $request->all();
            $data['servicename'] = $service_id;
            $validator = Validator::make($data, [
                'servicename' => 'required|exists:type_services,id',
                'price'       => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
                'quantity'    => 'required|numeric|min:1|max:5000',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'status'  => 2 ,
                    'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                    'errors'  => $validator->errors()
                ]);          
            }
            try {
                $service = Service::create([
                    'type_service_id' => $service_id,
                    'order_id'        => (int)$id,
                    'quantity'        => (int)$request->quantity,
                    'price'           => $request->price,
                ]);
                $order = $service->order;
                $order->price_work = $order->price_work + ($service->price * $service->quantity);
                $order->total_price = $order->total_price + ($service->price * $service->quantity);
                $order->save();
            } catch (QueryException $e) {
                return response()->json([
                    'status'  => 3 ,
                    'message' => ['Ошибка добавления услуги!', 'danger'],
                    'error'   => $e
                ]);          
            }
            $id       = $service->id;
            $price    = $service->price;
            $quantity = $service->quantity;
            $name     = $service->typeService->name;

            return response()->json([
                'status'  => 1 , 
                'message' => ['Услуга добавлена', 'success'],
                'info'    => [
                        'id'    => $id,
                        'name'  => $name,
                        'price' => [
                            'item'  => $price,
                            'all'   => $order->price_work,
                            'total' => $order->total_price
                    ],
                    'quantity' => $quantity,
                    'currency' => session('currency'),

                ],
            ]);
        }
        return response()->json([
            'status'  => 3 ,
            'message' => ['Ошибка добавления услуги!', 'danger']
        ]);
    }

    public function updateService(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $validator = Validator::make($request->all(), [
            'price'       => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
            'quantity'    => 'required|numeric|min:1|max:5000',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 2 ,
                'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                'errors'  => $validator->errors()
            ]);          
        }
        $order_id   = (int)$id;
        $service_id = (int)$request->id;
        $item = Service::where('id', $service_id)
                       ->where('order_id', $order_id)
                       ->get()
                       ->first();
        if ($item) {
            $old_price    = $item->price;
            $old_quantity = $item->quantity;
            $new_price    = $request->price;
            $new_quantity = $request->quantity;
            if ($old_price != $new_price || $old_quantity != $new_quantity) {
                $order = Order::find($order_id);
                if ($order) {
                    $item = $item->update([
                        'price' => $new_price,
                        'quantity' => $new_quantity,
                    ]);
                    if ($item) {
                        $order->price_work = $order->price_work - ($old_price * $old_quantity) + ($new_price * $new_quantity);
                        $order->total_price = $order->total_price - ($old_price * $old_quantity) + ($new_price * $new_quantity);
                        $order->save();
                        return response()->json([
                            'status'  => 1 , 
                            'message' => ['Услуга обновлена', 'success'],
                            'info'    => [
                                    'id'    => $service_id,
                                    'price' => [
                                        'item'  => $new_price,
                                        'all'   => $order->price_work,
                                        'total' => $order->total_price,
                                    ],
                                    'quantity' => $new_quantity,
                                    'currency' => session('currency'),
                            ],
                        ]);            
                    }
                    $error_message = 'Ошибка обновления услуги';      
                }
                $error_message = 'Неверный номер заказа'; 
            }
            $error_message = 'Вы не изменили значения';
        }
        $error_message = $error_message??'Данной услуги не существует';
        return response()->json([
            'status'  => 3 ,
            'message' => [$error_message, 'danger']
        ]);
    }

    public function deleteService(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $order_id   = (int)$id;
        $service_id = (int)$request->id;
        $item = Service::where('id', $service_id)
                       ->where('order_id', $order_id)
                       ->get()
                       ->first();
        if ($item) {
            $old_price    = $item->price;
            $old_quantity = $item->quantity;
                $order = Order::find($order_id);
                if ($order) {
                    $item = $item->delete();
                    if ($item) {
                        $order->price_work = $order->price_work - ($old_price * $old_quantity);
                        $order->total_price = $order->total_price - ($old_price * $old_quantity);
                        $order->save();
                        return response()->json([
                            'status'  => 1 , 
                            'message' => ['Услуга удалена', 'success'],
                            'info'    => [
                                    'id'    => $service_id,
                                    'price' => [
                                        'all'   => $order->price_work,
                                        'total' => $order->total_price,
                                    ],
                                    'currency' => session('currency'),
                            ],
                        ]);            
                    }
                    $error_message = 'Ошибка удаления услуги';      
                }
                $error_message = 'Неверный номер заказа'; 
        }
        $error_message = $error_message??'Данной услуги не существует';
        return response()->json([
            'status'  => 3 ,
            'message' => [$error_message, 'danger']
        ]);
    }

    public function addRepairPart(Request $request, $orderId)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $repairPart = strip_tags($request->repairpartname);
        if (preg_match('/^new_/', $repairPart)) {
            $repairPart = substr($repairPart, 4);
            $item       = TypeRepairPart::where('name', $repairPart)->get(['id']);
            if (!$item->count()) {
                $validator = Validator::make($request->all(), [
                    'repairpartname' => 'required|max:50',
                    'selfpart'       => 'nullable|numeric|max:1',
                    'price'          => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
                    'description'    => 'nullable|string|max:200',
                    'quantity'       => 'required|numeric|min:0|max:5000',
                ]);
                if ($validator->fails()) {
                    return response()->json(['status' => 2 , 'message' => ['Неверно заполненные поля помечены красным', 'danger'], 'errors' => $validator->errors()]);          
                }
                $repairPart_id = TypeRepairPart::create([
                    'name'        => $repairPart,
                    'selfpart'    => (int)$request->selfpart,
                    'price'       => $request->price,
                    'description' => $request->description,
                    'quantity'    => $request->quantity,
                ])->id;
            } else {
                $repairPart_id = (int)$item->first()->id;
            }
        } else {
            $repairPart_id = (int)$repairPart;
        }
        if ($repairPart_id) {
            $data = $request->all();
            $data['repairpartname'] = $repairPart_id;
            $validator = Validator::make($data , [
                'repairpartname' => 'required|exists:type_repair_parts,id',
                'selfpart'       => 'nullable|numeric|max:1',
                'price'          => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
                'quantity'       => 'required|numeric|min:0|max:5000',
            ]);
            if ($validator->fails()) {
                return response()->json(['status' => 2 , 'message' => ['Неверно заполненные поля помечены красным', 'danger'], 'errors' => $validator->errors()]);          
            }
            try {
                $repairPart = RepairPart::create([
                    'type_repairparts_id' => $repairPart_id,
                    'order_id'            => (int)$orderId,
                    'quantity'            => (int)$request->quantity,
                    'price'               => $request->price,
                    'selfpart'            => (int)$request->selfpart,
                    'quantity'            => $request->quantity,
                ]);
                $order = $repairPart->order;
                if (!(int)$request->selfpart) {
                    $order->price_repair_parts = $order->price_repair_parts + ($repairPart->price * $repairPart->quantity);
                    $order->total_price = $order->total_price + ($repairPart->price * $repairPart->quantity);
                    $order->save();
                }
                $type_repairPart = $repairPart->typeRepairPart;
                $type_repairPart->sales = $type_repairPart->sales + $request->quantity;
                $type_repairPart->quantity = $type_repairPart->quantity - $request->quantity;
                $type_repairPart->save();
            } catch (QueryException $e) {
                return response()->json([
                    'status'  => 3 ,
                    'message' => ['Ошибка добавления материала!', 'danger'],
                    'error'   => $e
                ]);          
            }
            $id       = $repairPart->id;
            $price    = $repairPart->price;
            $quantity = $repairPart->quantity;
            $selfpart = $repairPart->selfpart;
            $name     = $repairPart->typeRepairPart->name;
            return response()->json([
                'status'  => 1 ,
                'message' => ['Материал добавлен', 'success'],
                'info'    => [
                        'id'    => $id,
                        'name'  => $name,
                        'price' => [
                            'item'  => $price,
                            'all'   => $order->price_repair_parts,
                            'total' => $order->total_price
                    ],
                    'quantity' => $quantity,
                    'selfpart' => $selfpart,
                    'currency' => session('currency'),
                ],
            ]);
        }
        return response()->json([
            'status'  => 3 ,
            'message' => ['Ошибка добавления материала!', 'danger']
        ]);
    }

    public function updateRepairPart(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $validator = Validator::make($request->all(), [
            'price'       => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
            'quantity'    => 'required|numeric|min:1|max:5000',
            'selfpart'       => 'nullable|numeric|max:1',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 2 ,
                'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                'errors'  => $validator->errors()
            ]);          
        }
        $order_id   = (int)$id;
        $service_id = (int)$request->id;
        $item = RepairPart::where('id', $service_id)
                          ->where('order_id', $order_id)
                          ->get()
                          ->first();
        if ($item) {
            $old_price    = $item->price;
            $old_quantity = $item->quantity;
            $old_selfpart = (int)$item->selfpart;
            $new_price    = $request->price;
            $new_quantity = $request->quantity;
            $new_selfpart = (int)$request->selfpart;
            if ($old_price != $new_price || $old_quantity != $new_quantity || $old_selfpart != $new_selfpart) {
                $order = Order::find($order_id);
                if ($order) {
                    $type_repairPart = $item->typeRepairPart;
                    $item = $item->update([
                        'price'    => $new_price,
                        'quantity' => $new_quantity,
                        'selfpart' => $new_selfpart,
                    ]);
                    if ($item) {
                        if (!$old_selfpart && !$new_selfpart) {
                            $old_repairPart_price = $old_price * $old_quantity;
                            $new_repairPart_price = $new_price * $new_quantity;
                        } elseif (!$old_selfpart && $new_selfpart) {
                            $old_repairPart_price = $old_price * $old_quantity;
                            $new_repairPart_price = 0;
                        } elseif ($old_selfpart && !$new_selfpart) {
                            $old_repairPart_price = 0;
                            $new_repairPart_price = $new_price * $new_quantity;
                        } else {
                            $old_repairPart_price = 0;
                            $new_repairPart_price = 0;
                        }
                        $order->price_repair_parts = $order->price_repair_parts - $old_repairPart_price + $new_repairPart_price;
                        $order->total_price        = $order->total_price - $old_repairPart_price + $new_repairPart_price;
                        $order->save();
                        $type_repairPart->sales = $type_repairPart->sales - $old_quantity + $new_quantity;
                        $type_repairPart->quantity = $type_repairPart->quantity + $old_quantity - $new_quantity;
                        $type_repairPart->save();
                        return response()->json([
                            'status'  => 1 , 
                            'message' => ['Материал обновлен', 'success'],
                            'info'    => [
                                    'id'    => $service_id,
                                    'price' => [
                                        'item'  => $new_price,
                                        'all'   => $order->price_repair_parts,
                                        'total' => $order->total_price,
                                    ],
                                    'quantity' => $new_quantity,
                                    'selfpart' => $new_selfpart,
                                    'currency' => session('currency'),
                            ],
                        ]);            
                    }
                    $error_message = 'Ошибка обновления материала';      
                }
                $error_message = 'Неверный номер заказа'; 
            }
            $error_message = 'Вы не изменили значения';
        }
        $error_message = $error_message??'Данного материала не существует';
        return response()->json([
            'status'  => 3 ,
            'message' => [$error_message, 'danger']
        ]);
    }

    public function deleteRepairPart(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $order_id   = (int)$id;
        $service_id = (int)$request->id;
        $item = RepairPart::where('id', $service_id)
                          ->where('order_id', $order_id)
                          ->get()
                          ->first();
        if ($item) {
            $old_price    = $item->price;
            $old_quantity = $item->quantity;
            $old_selfpart = (int)$item->selfpart;
                $order = Order::find($order_id);
                if ($order) {
                    $type_repairPart = $item->typeRepairPart;
                    $item = $item->delete();
                    if ($item) {
                        if (!$old_selfpart) {
                            $order->price_repair_parts = $order->price_repair_parts - ($old_price * $old_quantity);
                            $order->total_price        = $order->total_price - ($old_price * $old_quantity);
                            $order->save();
                            $type_repairPart->sales = $type_repairPart->sales - $old_quantity;
                            $type_repairPart->quantity = $type_repairPart->quantity + $old_quantity;
                            $type_repairPart->save();    
                        } else {
                            if ($type_repairPart->selfpart == 1) {
                                $type_repairPart->delete();
                            }
                        }
                        return response()->json([
                            'status'  => 1 , 
                            'message' => ['Материал удален', 'success'],
                            'info'    => [
                                    'id'    => $service_id,
                                    'price' => [
                                        'all'   => $order->price_repair_parts,
                                        'total' => $order->total_price,
                                    ],
                                    'currency' => session('currency'),
                            ],
                        ]);            
                    }
                    $error_message = 'Ошибка удаления материала';      
                }
                $error_message = 'Неверный номер заказа'; 
        }
        $error_message = $error_message??'Данного материала не существует';
        return response()->json([
            'status'  => 3 ,
            'message' => [$error_message, 'danger']
        ]);
    }

    public function addDiscount(Request $request, $order_id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $validator = Validator::make($request->all(), [
            'discount' => 'numeric|regex:/^-?\d{1,10}(\.\d{1,2})?$/'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 2 , 'message' => ['Неверно заполненные поля помечены красным', 'danger'], 'errors' => $validator->errors()]);
        }

        $order = Order::find((int)$order_id);
        if ($order) {
            $order->total_price = $order->total_price + $order->discount - (float)$request->discount;
            $order->discount = (float)$request->discount;
            if ($order->save()) {
                return response()->json([
                    'status'  => 1 ,
                    'message' => ['Скидка изменена', 'success'],
                    'info'    => [
                        'discount' => $order->discount,
                        'total'    => $order->total_price,
                        'currency' => session('currency'),
                    ],
                ]);
            }
        };
        return response()->json([
            'status'  => 3 ,
            'message' => ['Ошибка изменения скидки!', 'danger']
        ]);
    }

    public function getAllId($request, $model)
    {
        if (is_array($request)) {
            $model    = '\\App\\Models\\' . $model;
            $ids = array_map(function ($item) use ($model) {
                                $item = strip_tags($item);
                                if (preg_match('/^new_/', $item)) {
                                    $item = substr($item, 4);
                                    $in_db = $model::where('name', $item);
                                    if (!$in_db->get(['id'])->count()) {
                                        $id = $in_db->create(['name' => $item])->id;
                                    } else {
                                        $id = (int)$in_db->get(['id'])->first()->id;
                                    }
                                } else {
                                    $id = (int)$item;
                                }
                                return $id;
                            }, $request);
            return $ids = implode(',', $ids);
        } else {
            return $ids = '';
        }
    }
}
