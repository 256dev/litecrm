<?php

namespace App\Http\Controllers\CRM;

use App\Models\Device;
use App\Models\Defect;
use App\Models\Customer;
use App\Models\Condition;
use App\Models\CustomerPhone;
use App\Models\Equipment;
use App\Models\DeviceModel;
use App\Models\Manufacturer;
use App\Models\Order;
use App\Models\OrderStatus;
use App\Models\TypeDevice;
use App\Models\TypeService;
use App\Models\TypeRepairPart;
use App\Models\User;
use Date;
use Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SearchController extends CrmBaseController
{
    public function searchCustomer(Request $request)
    {   
        $search = strip_tags($request->input('search'));
        if ($search) {
            $search_name  = true;
            $search_phone = true;
            $type_search = str_split($search);
            foreach ($type_search as $char) {
                if ($search_phone && ((int)$char || (int)$char == 0)) {
                    $search_phone = true;
                } else {
                    $search_phone = false;
                }
                if ($char == '@') {
                    $search_name  = false;
                }
            }

            $data = Customer::where('email', 'LIKE', "%${search}%");
            if ($search_name) {
                $data->orWhere('name', 'LIKE', "%${search}%");
            }
            if ($search_phone && mb_strlen($search) > 1) {
                $search = $search;
                $cutomers = CustomerPhone::where('phone', 'LIKE', "%${search}%")
                                        ->leftJoin('customers', 'customer_id', 'id')
                                        ->select([
                                            'customers.id AS id',
                                            'customers.name AS name'
                                        ]);
                $data->union($cutomers);
            }
            $data = $data->limit(10)->orderBy('id', 'ASC')->get(['id', 'name'])->unique('id');
        } else {
            $data = [];
        }
        return response()->json($data);
    }

    public function searchSN(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = Device::where('sn', 'LIKE', "%${search}%")->limit(10)->get(['id', 'SN']);
        } else {
            $data = [];
        }

        return response()->json($data);
    }

    public function searchModel(Request $request)
    {
        $search = strip_tags($request->input('search'));
        $data = DeviceModel::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);

        return response()->json(($data));
    }

    public function searchDefect(Request $request)
    {

        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = Defect::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = Defect::where('main', 1)->orderBy('priority', 'ASC')->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchCondition(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = Condition::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = Condition::where('main', 1)->orderBy('priority', 'ASC')->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchEquipment(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = Equipment::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = Equipment::where('main', 1)->orderBy('priority', 'ASC')->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchManufacturer(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = Manufacturer::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = Manufacturer::where('main', 1)->orderBy('priority', 'ASC')->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchTypeDevice(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = TypeDevice::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = TypeDevice::where('main', 1)->orderBy('priority', 'ASC')->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchService(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = TypeService::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = TypeService::where('main', 1)->orderBy('priority', 'ASC')->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchRepairPart(Request $request)
    {
        $search = strip_tags($request->input('search'));
        if ($search) {
            $data = TypeRepairPart::where('name', 'LIKE', "%${search}%")->limit(10)->get(['id', 'name']);
        } else {
            $data = TypeRepairPart::where('id', 'LIKE', "%%")->limit(15)->get(['id', 'name']);
        }

        return response()->json($data);
    }

    public function searchStatus()
    {
        $data = OrderStatus::all(['id', 'name']);
        
        return response()->json($data);
    }

    public function searchTop(Request $request)
    {
        $search = $request->search;
        $type   = strip_tags($request->type);
        $search = strip_tags($request->input('search'));
        switch($type) {
            case 'order':
                $data = $this->searchTopOrder($search);
                break;
            case 'main':
                $data = $this->searchTopOrder($search, true);
                break;
            case 'customers':
                $data = $this->searchTopCustomer($search);
                break;
            case 'users':
                $data = $this->searchTopUser($search);
                break;
            case 'devicemodels':
                $data = $this->searchDeviceModels($search);
                break;
            default:
                $data = $this->searchTopByName($search, $type);
        }
        return response()->json($data);
    }

    public function searchTopOrder($search, $filter = false)
    {
        $data = Order::where('devices.sn', 'LIKE', "%${search}%")
                     ->orWhere('orders.number', 'LIKE', "%${search}%")
                     ->orWhere('customers.name', 'LIKE', "%${search}%")
                     ->orWhere('device_models.name', 'LIKE', "%${search}%");
        if ($filter) {
            $data->whereIn('order_statuses.id', [1,2,3,4]);
        }
        $data = $data->join('devices', 'orders.device_id','devices.id')
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
                     ]);
        if ($search) {
            $data = $data->limit(10);
        }
        $data = $data->orderBy('orders.id', 'DESC')
                     ->get()
                     ->unique('id');
        foreach ($data as $item) {
            $item->urgency = $item->urgency? 'bg-urgency':'';
            $item->orderId = route('orders.show', $item->id);
            $item->customerId = route('customers.show', $item->customerId);
            $item->date =  Date::parse($item->date)->tz(config('custom.tz'))->format('j F Y в H:i');
            $item->currency = Session::get('currency');
        }
        return $data;
    }

    public function searchTopCustomer($search)
    {
        $search_name  = true;
        $search_phone = true;
        $type_search = str_split($search);
        foreach ($type_search as $char) {
            if ($search_phone && ((int)$char || (int)$char == 0)) {
                $search_phone = true;
            } else {
                $search_phone = false;
            }
            if ($char == '@') {
                $search_name  = false;
            }
        }
        $data = Customer::where('email', 'LIKE', "%${search}%");
        if ($search_name) {
            $data->orWhere('name', 'LIKE', "%${search}%")
                ->select([
                    'customers.id                AS id',
                    'customers.name              AS name',
                    'customers.all_orders        AS all_orders',
                    'customers.orders_in_process AS orders_in_process'
                ]);
        }
        if ($search_phone) {
            $search = $search;
            $cutomers = CustomerPhone::where('phone', 'LIKE', "%${search}%")
                                    ->leftJoin('customers', 'customer_id', 'id')
                                    ->select([
                                        'customers.id                AS id',
                                        'customers.name              AS name',
                                        'customers.all_orders        AS all_orders',
                                        'customers.orders_in_process AS orders_in_process'
                                    ]);
            $data->union($cutomers);
        }
        if ($search) {
            $data = $data->limit(10);
        }
        $data = $data->orderBy('id', 'DESC')->get()->unique('id');
        if ($data) {
            foreach ($data as $item) {
                $item->routeId = route('customers.show', $item->id);
                $item->orderId = route('orders.create', $item->id);
                $item->phone;
            }
        }
        return $data;
    }

    public function searchTopUser($search)
    {
        $search_name  = true;
        $search_phone = true;
        $type_search = str_split($search);
        foreach ($type_search as $char) {
            if ($search_phone && ((int)$char || (int)$char == 0)) {
                $search_phone = true;
            } else {
                $search_phone = false;
            }
            if ($char == '@') {
                $search_name  = false;
            }
        }
        $data = User::where('users.email', 'LIKE', "%${search}%");
        if ($search_name) {
            $data->orWhere('users.name', 'LIKE', "%${search}%");
        }
        if ($search_phone) {
            $data->orWhere('users.phones', 'LIKE', "%${search}%");
        }
        $data = $data->join('roles', 'users.role_id', 'roles.id')
                     ->select([
                        'users.id         AS id',
                        'users.name       AS name',
                        'users.email      AS email',
                        'users.phones     AS phones',
                        'roles.name       AS role',
                        'users.deleted_at AS deleted',
                       ]);
        if ($search) {
            $data = $data->limit(10);
        }
        $data = $data->withTrashed()
                     ->orderBy('users.deleted_at', 'ASC')
                     ->orderBy('id', 'ASC')
                     ->get();
        if ($data) {
            foreach ($data as $item) {
                $item->routeId = route('users.show', $item->id);
                $item->phones = json_decode($item->phones);
            }
        }
        return $data;
    }

    public function searchDeviceModels($search)
    {
        $data = DeviceModel::where('device_models.name', 'LIKE', "%${search}%")
                           ->orWhere('manufacturers.name', 'LIKE', "%${search}%")
                           ->orWhere('type_devices.name', 'LIKE', "%${search}%")
                           ->join('manufacturers', 'device_models.manufacturer_id', 'manufacturers.id' )
                           ->join('type_devices', 'device_models.type_device_id', 'type_devices.id' )
                           ->select([
                               'device_models.id   AS id',
                               'device_models.name AS name',
                               'manufacturers.name AS manufacturer',
                               'type_devices.name  AS typeDevice'
                           ])
                           ->get();
        if ($data) {
            foreach ($data as $item) {
                $item->routeId = route('devicemodels.show', $item->id);
            }
        }
        return $data;
    }

    public function searchTopByName($search, $type)
    {
        switch($type) {
            case 'typerepairparts':
                $data = TypeRepairPart::where('name', 'LIKE', "%${search}%")
                    ->get(['id', 'name', 'price AS info', 'main', 'priority']);
                break;
            case 'typeservices':
                $data = TypeService::where('name', 'LIKE', "%${search}%")
                ->get(['id', 'name', 'price AS info', 'main', 'priority']);
                break;
            case 'conditions':
                $data = Condition::where('name', 'LIKE', "%${search}%")
                    ->get(['id', 'name', 'comment AS info', 'main', 'priority']);
                break;
            case 'defects':
                $data = Defect::where('name', 'LIKE', "%${search}%")
                    ->get(['id', 'name', 'comment AS info', 'main', 'priority']);
                break;
            case 'equipments':
                $data = Equipment::where('name', 'LIKE', "%${search}%")
                    ->get(['id', 'name', 'comment AS info', 'main', 'priority']);
                break;
            case 'manufacturers':
                $data = Manufacturer::where('name', 'LIKE', "%${search}%")
                    ->get(['id', 'name', 'comment AS info', 'main', 'priority']);
                break;
            case 'typedevices':
                $data = TypeDevice::where('name', 'LIKE', "%${search}%")
                    ->get(['id', 'name', 'comment AS info', 'main', 'priority']);
                break;
            default:
                $data = [];
        }
        if ($data) {
            foreach ($data as $item) {
                $item->routeId = route($type . '.show', $item->id);
                $item->currency = Session::get('currency');
            }
        }
        return $data;
    }
}
