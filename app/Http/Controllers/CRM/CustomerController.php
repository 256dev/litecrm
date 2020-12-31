<?php

namespace App\Http\Controllers\CRM;

use App\Models\Order;
use App\Models\Customer;
use App\Models\CustomerPhone;
use Illuminate\Http\Request;

use Validator;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Collection;

class CustomerController extends CrmBaseController
{
    public function index()
    {
        $customers = Customer::select('id', 'name', 'all_orders', 'orders_in_process')
                             ->orderBy('id', 'DESC')
                             ->get();
        foreach ($customers as $customer) {   
            $customer->phones = $customer->phone;
        }
        return view('main.customer.showAll', compact('customers'));
    }

    public function show($id)
    {
        $id       = (int)$id;
        $customer = Customer::find($id);
        if (!$customer) {
            abort('404');
        }
        $phones   = CustomerPhone::where('customer_id', $id)->get();
        $orders = Order::where('orders.customer_id', $id)
                       ->join('devices', 'orders.device_id','devices.id')
                       ->join('device_models', 'devices.device_model_id', 'device_models.id')
                       ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                       ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                       ->join('order_histories', 'orders.last_history_id','order_histories.id')
                       ->join('order_statuses', 'order_histories.status_id', 'order_statuses.id')
                       ->select([
                           'orders.id            AS id',
                           'orders.number        AS number',
                           'devices.SN           AS sn',
                           'type_devices.name    AS type',
                           'manufacturers.name   AS manufacturer',
                           'device_models.name   AS model',
                           'order_statuses.name  AS status',
                           'order_statuses.color AS color',
                           'orders.date_contract AS date',
                           'orders.total_price   AS price',
                           'orders.prepayment    AS prepayment',
                       ])
                       ->get();
        return view('main.customer.show', compact('customer', 'phones', 'orders'));
    }

    public function create()
    {
        $phones = new Collection();
        return view('main.customer.addUpdate', compact(['phones']));
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseCustomerValidator($request)) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 2 ,
                    'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                    'errors' => $validator->errors()
                ]);          
            };
            return redirect()->route('customers.create')->withErrors($validator)->withInput();
        }

        $phones = [];
        for ($i = 1; $i < 4; $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                    $telegram = isset($request["telegram${i}"]) ? 1 : 0;
                    $viber    = isset($request["viber${i}"]) ? 1 : 0;
                    $whatsapp = isset($request["whatsapp${i}"]) ? 1 : 0;
                    $phones[] = [$phone, $telegram, $viber, $whatsapp];
                }
        }
        
        $name     = (string)$request['name'];
        $email    = (string)$request['email'];
        $passport = (string)$request['passport'];
        $address  = (string)$request['address'];
        $status   = (string)$request['status'];
        $comment  = (string)$request['comment'];

        try {
            $customer = Customer::create([
                'name'          => $name,
                'email'         => $email,
                'passport'      => $passport,
                'address'       => $address,
                'status'        => $status,
                'comment_about' => $comment,
            ]);
            foreach ($phones as $phone) {
                $customer->phone()->create([
                    'customer_id' => $customer->id,
                    'phone'       => (string)$phone[0],
                    'telegram'    => (string)$phone[1],
                    'viber'       => (string)$phone[2],
                    'whatsapp'    => (string)$phone[3],
                ]);
            }
        } catch (QueryException $e) {
            if ($request->ajax()) {
                return response()->json([
                    'status' => 3,
                    'message' => ['Ошибка добавления записи!', 'danger'],
                    'error' => $e
                ]);          
            };
            return redirect()->route('customers.create')->withInput()->withErrors('Ошибка добавления записи!');
        }
        if ($request->ajax()) {
            return response()->json([
                'status' => 1,
                'message' => ['Новый клиент создан!', 'success'],
                'id' => $customer->id
            ]);          
        };
        return redirect()->route('customers.index')->with('message', 'Клиент создан!');
    }

    public function edit(Request $request, $id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $customer = Customer::find($id);
        if (!$customer) {
            abort('404');
        }
        $edit = 1;
        $phones   = CustomerPhone::where('customer_id', $id)->get();

        return view('main.customer.addUpdate', compact('customer', 'phones', 'edit'));
    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if ($validator = $this->baseCustomerValidator($request)) {
            return redirect()->route('customers.edit', $id)->withErrors($validator)->withInput();
        }
        
        $phones = [];
        for ($i = 1; $i < 4; $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                    $telegram = isset($request["telegram${i}"]) ? 1 : 0;
                    $viber    = isset($request["viber${i}"]) ? 1 : 0;
                    $whatsapp = isset($request["whatsapp${i}"]) ? 1 : 0;
                    $phones[] = [$phone, $telegram, $viber, $whatsapp];
                }
        }

        $name     = (string)$request['name'];
        $email    = (string)$request['email'];
        $passport = (string)$request['passport'];
        $address  = (string)$request['address'];
        $status   = (string)$request['status'];
        $comment  = (string)$request['comment'];

        try {
            $customer = Customer::where('id', '=', $id)->update([
                'name'          => $name,
                'email'         => $email,
                'passport'      => $passport,
                'address'       => $address,
                'status'        => $status,
                'comment_about' => $comment,
            ]);
            $customer = Customer::find($id);
            for ($i = 0; $i < 3; $i++) {
                if (!isset($phones[$i]) && isset($customer->phone[$i])) {
                    $customer->phone()->where('phone', '=', $customer->phone[$i]->phone)->delete();
                    continue;
                }
                if (isset($phones[$i]) && isset($customer->phone[$i])) {
                    $customer->phone()->where('phone', '=', $customer->phone[$i]->phone)->update([
                        'phone'    => $phones[$i][0],
                        'telegram' => $phones[$i][1],
                        'viber'    => $phones[$i][2],
                        'whatsapp' => $phones[$i][3],
                        ]);
                    continue;
                }
                if (isset($phones[$i]) && !isset($customer->phone[$i])) {
                    $customer->phone()->create([
                        'phone'    => $phones[$i][0],
                        'telegram' => $phones[$i][1],
                        'viber'    => $phones[$i][2],
                        'whatsapp' => $phones[$i][3],
                        ]);
                    continue;
                }
            }
        } catch (QueryException $e) {
            return redirect()->route('customers.edit', $id)->withInput()->withErrors('Ошибка добавления записи!');
        }
        return redirect()->route('customers.show', $id)->with('message', 'Данные обновлены.');
    }

    public function destroy($id)
    {
        try {
            Customer::where('id', '=', $id)->delete();
        } catch (QueryException $e) {
            return redirect()->route('customers.show', $id)->withInput()->withErrors('Ошибка! У пользователя оформлен заказ.');
        }
        
        return redirect()->route('customers.index')->with('message', 'Пользователь удалён.');
    }
}
