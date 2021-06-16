<?php

namespace App\Http\Controllers\CRM;

use App\Models\Order;
use App\Models\Service;
use App\Models\Customer;
use App\Models\AppSettings;
use App\Models\CustomerPhone;
use App\Models\RepairPart;
use App\Models\TypeRepairPart;
use PDF;
use Picqer\Barcode\BarcodeGeneratorHTML;

class ConvertToPDFController extends CrmBaseController
{
    public function downloadReceiptDevice($id)
    {
        $unit_id  = 1;
        $settings = $this->unitInfo($unit_id);
        $order    = $this->orderInfo($id);
        $customer = $this->customerInfo($order->customer_id);

        $generator = new BarcodeGeneratorHTML();
        $order_barcode = $generator->getBarcode((string)$order->number, $generator::TYPE_CODE_128, 1, 25);
        $device_barcode = $generator->getBarcode((string)$order->sn, $generator::TYPE_CODE_128, 1, 25);

        $pdf = PDF::loadView('main.pdf.receipt', compact('settings', 'customer', 'order', 'order_barcode', 'device_barcode'));
        $file_name = 'receipt-' . $order->number . '.pdf';
        return $pdf->stream($file_name)->header('Content-Type','application/pdf');
    }

    public function downloadAct($id)
    {
        $unit_id  = 1;
        $settings = $this->unitInfo($unit_id);
        $order    = $this->orderInfo($id);
        $customer = $this->customerInfo($order->customer_id);

        $services = Service::where('services.order_id', $order->id)
                                        ->join('type_services', 'services.type_service_id', 'type_services.id')
                                        ->select([
                                            'type_services.name AS name',
                                            'services.price     AS price',
                                            'services.quantity  AS quantity',
                                        ])
                                        ->get();
        $order->price_work = 0;
        foreach ($services as $service) {
            $order->price_work += $service->price * $service->quantity;
        }
        $repairParts = RepairPart::where('repair_parts.order_id', $order->id)
                                ->join('type_repair_parts AS type', 'repair_parts.type_repairparts_id', 'type.id' )
                                ->select([
                                    'type.name             AS name',
                                    'repair_parts.quantity AS quantity',
                                    'repair_parts.price    AS price',
                                    'repair_parts.selfpart AS selfpart',
                                ])
                                ->get();
        $order->price_repair_parts = 0;
        foreach ($repairParts as $repairPart) {
            if (!$repairPart->selfpart) {
                $order->price_repair_parts += $repairPart->price * $repairPart->quantity;
            }
        }
        $order->total_price = $order->price_work + $order->price_repair_parts - $order->prepayment - $order->discount;
        $generator = new BarcodeGeneratorHTML();
        $device_barcode = $generator->getBarcode((string)$order->sn, $generator::TYPE_CODE_128, 1, 25);
        $pdf = PDF::loadView('main.pdf.act', compact('settings', 'customer', 'order', 'services', 'repairParts', 'device_barcode'));
        $file_name = 'act-' . $order->number . '.pdf';
        return $pdf->stream($file_name)->header('Content-Type','application/pdf');
    }

    public function unitInfo($id)
    {
        $settings = AppSettings::where('id', $id)
                               ->select([
                                   'name',
                                   'legal_name',
                                   'phones',
                                   'email',
                                   'address',
                                   'repair_conditions',
                               ])
                               ->get()
                               ->first();
        $settings->phones = json_decode($settings->phones);
        return $settings;
    }

    public function orderInfo($id)
    {
        $order = Order::where('orders.id', $id)
                      ->join('devices', 'orders.device_id','devices.id')
                      ->join('device_models', 'devices.device_model_id', 'device_models.id')
                      ->join('type_devices', 'device_models.type_device_id', 'type_devices.id')
                      ->join('manufacturers','device_models.manufacturer_id', 'manufacturers.id')
                      ->select([
                          'orders.id            AS id',
                          'orders.prepayment    AS prepayment',
                          'orders.agreed_price  AS agreed_price',
                          'orders.discount      AS discount',
                          'orders.number        AS number',
                          'orders.customer_id   AS customer_id',
                          'orders.defect        AS defect',
                          'orders.equipment     AS equipment',
                          'orders.condition     AS condition',
                          'devices.SN           AS sn',
                          'type_devices.name    AS type',
                          'manufacturers.name   AS manufacturer',
                          'device_models.name   AS model',
                          'orders.date_contract AS date',
                          'orders.order_comment AS comment',
                      ])
                      ->get()
                      ->first();
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
        return $order;
    }

    public function customerInfo($id)
    {
        $customer = Customer::select('id', 'name', 'address')->where('id', $id)->get()->first();
        $customer->phones = implode(', ', $customer->phone->pluck('phone')->toArray());
        return $customer;
    }

    public function downloadReportRepairPart()
    {
        $this->authorize('report', \Auth::user());

        $unit_id = 1;
        $repairParts = TypeRepairPart::select([
            'name',
            'price',
            'quantity',
            'sales',
            'description',
        ])->get();

        $settings = $this->unitInfo($unit_id);

        $pdf = PDF::loadView('main.pdf.repairParts', compact('settings', 'repairParts'));
        return $pdf->stream('repair parts.pdf')->header('Content-Type','application/pdf');
    }

    public function downloadReportServices()
    {
        $this->authorize('report', \Auth::user());

        $services = Service::with(['typeService'])
            ->select([
                'type_service_id',
                'quantity',
                'price',
            ])
            ->get();
        $count_services = $services->count();
        $sum_services = $services->sum('price');
        $services = $services->groupBy('type_service_id');

        $unit_id = 1;
        $settings = $this->unitInfo($unit_id);

        $pdf = PDF::loadView('main.pdf.services', compact('settings', 'services', 'count_services', 'sum_services'));
        return $pdf->stream('services.pdf')->header('Content-Type','application/pdf');
    }
}
