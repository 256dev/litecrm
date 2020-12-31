<?php

namespace App\Http\Controllers\CRM;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ManufacturerController extends CrmBaseController
{
    public function index()
    {
        $items = Manufacturer::all();
        return view('main.manufacturer.showAll', compact('items'));
    }

    public function show(Request $request, $id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Manufacturer::find($id);
        if (!$item) {
            abort('404');
        }
        return view('main.manufacturer.show', compact('item'));
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
        $priority = (int)($request->priority??15);
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

    public function edit($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Manufacturer::Find($id);
        if (!$item) {
            abort('404');
        }
        $edit = 1;
        return view('main.manufacturer.addUpdate', compact('item', 'edit'));
    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Manufacturer::find($id);
        if (!$item) {
            abort('404');
        }
        if ($validator = $this->baseInfoValidator($request, 'manufacturername', 'Manufacturer', $id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name     = (string)$request->manufacturername;
        $main     = (int)$request->main;
        $priority = (int)($request->priority??15);
        $comment  = (string)$request->comment;
        $item = $item->update([
            'name'     => $name,
            'main'     => $main,
            'priority' => $priority,    
            'comment'  => $comment,
        ]);
        if ($item) {
            return redirect()->route('manufacturers.index')->with('message', 'Бренд обновлен');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления бренда');
    }

    public function destroy($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Manufacturer::find($id);
        if (!$item) {
            abort('404');
        }
        try {
            $item = $item->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Ошибка! Есть модели устройства с данным брендом');
        }
        if ($item) {
            return redirect()->route('manufacturers.index')->with('message', 'Бренд удален');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка! Есть модели устройства с данным брендом');
    }
}
