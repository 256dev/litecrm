<?php

namespace App\Http\Controllers\CRM;

use App\Models\TypeDevice;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TypeDeviceController extends CrmBaseController
{
    public function __construct() {
        $this->authorizeResource(TypeDevice::class, 'typedevice');
    }

    public function index()
    {
        $items = TypeDevice::all();
        return view('main.typeDevice.showAll', compact('items'));
    }

    public function show(TypeDevice $typedevice)
    {
        if (!$typedevice->id) {
            abort('404');
        }

        return view('main.typeDevice.show', ['item' => $typedevice]);
    }

    public function create()
    {
        return view('main.typeDevice.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseInfoValidator($request, 'typedevicename', 'TypeDevice')) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }
        $name     = (string)$request->typedevicename;
        $main     = (int)$request->main;
        $priority = (int)($request->priority??15);
        $comment  = (string)$request->comment;
        try {
            TypeDevice::create([
                'name'     => $name,
                'main'     => $main,
                'priority' => $priority,    
                'comment'  => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления типа устройства');
        }

        return redirect()->route('typedevices.index')->with('message', 'Новый тип устройства добавлен');
    }

    public function edit(TypeDevice $typedevice)
    {
        if (!$typedevice->id) {
            abort('404');
        }

        $edit = 1;
        return view('main.typeDevice.addUpdate', ['item' => $typedevice, 'edit' => $edit]);
    }

    public function update(Request $request, TypeDevice $typedevice)
    {
        if (!$typedevice->id) {
            abort('404');
        }
        
        if ($validator = $this->baseInfoValidator($request, 'typedevicename', 'TypeDevice', $typedevice->id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name     = (string)$request->typedevicename;
        $main     = (int)$request->main;
        $priority = (int)($request->priority ?? 15);
        $comment  = (string)$request->comment;
        $typedevice->update([
            'name'     => $name,
            'main'     => $main,
            'priority' => $priority,    
            'comment'  => $comment,
        ]);
        if ($typedevice) {
            return redirect()->route('typedevices.index')->with('message', 'Тип устройства обновлён');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления типа устройства');
    }

    public function destroy(TypeDevice $typedevice)
    {
        if (!$typedevice->id) {
            abort('404');
        }
        
        try {
            $typedevice->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Есть модели устройств с данным типом устройства');
        }
        if ($typedevice) {
            return redirect()->route('typedevices.index')->with('message', 'Тип устройства удалён');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка! Есть модели устройств с данным типом устройства');
    }
}
