<?php

namespace App\Http\Controllers\CRM;

use App\Models\DeviceModel;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DeviceModelController extends CrmBaseController
{
    public function __construct() {
        $this->authorizeResource(DeviceModel::class, 'devicemodel');
    }

    public function index()
    {
        $items = DeviceModel::join('manufacturers', 'device_models.manufacturer_id', 'manufacturers.id' )
                            ->join('type_devices', 'device_models.type_device_id', 'type_devices.id' )
                            ->select([
                                'device_models.id   AS id',
                                'device_models.name AS name',
                                'manufacturers.name AS manufacturer',
                                'type_devices.name  AS typeDevice'
                            ])
                            ->get();
        return view('main.deviceModels.showAll', compact('items'));
    }

    public function show(Request $request, DeviceModel $devicemodel)
    {
        if (!$devicemodel->id) {
            abort('404');
        }
        $item = DeviceModel::where('device_models.id', $devicemodel->id)
                ->join('manufacturers', 'device_models.manufacturer_id', 'manufacturers.id' )
                ->join('type_devices', 'device_models.type_device_id', 'type_devices.id' )
                ->select([
                    'device_models.id      AS id',
                    'device_models.name    AS name',
                    'device_models.comment AS comment',
                    'manufacturers.name    AS manufacturer',
                    'type_devices.name     AS typeDevice'
                ])
                ->get()
                ->first();
        if (!$item) {
            abort('404');
        }
        return view('main.deviceModels.show', compact('item'));
    }

    public function create()
    {
        return view('main.deviceModels.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->validateDeviceModel($request)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name            = (string)$request->devicemodelname;
        $manufacturer_id = $this->getId($request->manufacturer, 'Manufacturer');
        $typeDevice_id   = $this->getId($request->typedevice, 'TypeDevice');
        $comment         = (string)$request->comment;
        try {
            DeviceModel::create([
                'name'            => $name,
                'manufacturer_id' => $manufacturer_id,
                'type_device_id'  => $typeDevice_id,    
                'comment'         => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления модели');
        }
        return redirect()->route('devicemodels.index')->with('message', 'Модель добавлен');
    }

    public function edit(DeviceModel $devicemodel)
    {
        if (!$devicemodel->id) {
            abort('404');
        }
        $item = DeviceModel::where('device_models.id', $devicemodel->id)
                ->join('manufacturers', 'device_models.manufacturer_id', 'manufacturers.id' )
                ->join('type_devices', 'device_models.type_device_id', 'type_devices.id' )
                ->select([
                    'device_models.id      AS id',
                    'device_models.name    AS name',
                    'device_models.comment AS comment',
                    'manufacturers.id      AS manufacturerId',
                    'manufacturers.name    AS manufacturerName',
                    'type_devices.id       AS typeDeviceId',
                    'type_devices.name     AS typeDeviceName',
                ])
                ->get()
                ->first();
        if (!$item) {
            abort('404');
        }
        $edit = 1;
        return view('main.deviceModels.addUpdate', compact('item', 'edit'));
    }

    public function update(Request $request, DeviceModel $devicemodel)
    {
        if (!$devicemodel->id) {
            abort('404');
        }

        if ($validator = $this->validateDeviceModel($request, $devicemodel->id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name            = (string)$request->devicemodelname;
        $manufacturer_id = $this->getId($request->manufacturer, 'Manufacturer');
        $typeDevice_id   = $this->getId($request->typedevice, 'TypeDevice');
        $comment         = (string)$request->comment;
        $devicemodel = $devicemodel->update([
            'name'            => $name,
            'manufacturer_id' => $manufacturer_id,
            'type_device_id'  => $typeDevice_id,    
            'comment'         => $comment,
        ]);
        if ($devicemodel) {
            return redirect()->route('devicemodels.index')->with('message', 'Модель обновлена');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления модели');
    }

    public function destroy(DeviceModel $devicemodel)
    {
        if (!$devicemodel->id) {
            abort('404');
        }
        
        try {
            $devicemodel = $devicemodel->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Ошибка! Есть заказы с данной моделью');
        }
        if ($devicemodel) {
            return redirect()->route('devicemodels.index')->with('message', 'Модель удалена');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка! Есть заказы с данной моделью');
    }

    public function validateDeviceModel($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'devicemodelname' => 'required|string|max:50',
            'manufacturer'    => 'required',
            'typedevice'      => 'required',
            'comment'         => 'nullable|string|max:200',
        ]);

        $request = $request->devicemodelname;
        $validator = $this->baseNameValidator($validator, 'devicemodelname', 'DeviceModel', $request, $id);
        return $validator->fails() ? $validator : false;
    }
}
