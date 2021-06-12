<?php

namespace App\Http\Controllers\CRM;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ManufacturerController extends CrmBaseController
{
    public function __construct() {
        $this->authorizeResource(Manufacturer::class, 'manufacturer');
    }

    public function index()
    {
        $items = Manufacturer::all();
        return view('main.manufacturer.showAll', compact('items'));
    }

    public function show(Request $request, Manufacturer $manufacturer)
    {
        if (!$manufacturer->id) {
            abort('404');
        }

        return view('main.manufacturer.show', ['item' => $manufacturer]);
    }

    public function create()
    {
        return view('main.manufacturer.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseInfoValidator($request, 'manufacturername', 'Manufacturer')) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }
        $name     = (string)$request->manufacturername;
        $main     = (int)$request->main;
        $priority = (int)($request->priority ?? 15);
        $comment  = (string)$request->comment;
        try {
            Manufacturer::create([
                'name'     => $name,
                'main'     => $main,
                'priority' => $priority,    
                'comment'  => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления бренда');
        }
        return redirect()->route('manufacturers.index')->with('message', 'Бренд добавлен');
    }

    public function edit(Manufacturer $manufacturer)
    {
        if (!$manufacturer->id) {
            abort('404');
        }

        $edit = 1;

        return view('main.manufacturer.addUpdate', ['item' => $manufacturer, 'edit' => $edit]);
    }

    public function update(Request $request, Manufacturer $manufacturer)
    {
        if (!$manufacturer->id) {
            abort('404');
        }

        if ($validator = $this->baseInfoValidator($request, 'manufacturername', 'Manufacturer', $manufacturer->id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name     = (string)$request->manufacturername;
        $main     = (int)$request->main;
        $priority = (int)($request->priority ?? 15);
        $comment  = (string)$request->comment;
        $manufacturer = $manufacturer->update([
            'name'     => $name,
            'main'     => $main,
            'priority' => $priority,    
            'comment'  => $comment,
        ]);
        if ($manufacturer) {
            return redirect()->route('manufacturers.index')->with('message', 'Бренд обновлен');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления бренда');
    }

    public function destroy(Manufacturer $manufacturer)
    {
        if (!$manufacturer->id) {
            abort('404');
        }

        try {
            $manufacturer = $manufacturer->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Ошибка! Есть модели устройства с данным брендом');
        }
        if ($manufacturer) {
            return redirect()->route('manufacturers.index')->with('message', 'Бренд удален');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка! Есть модели устройства с данным брендом');
    }
}
