<?php

namespace App\Http\Controllers\CRM;

use App\Models\TypeRepairPart;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class TypeRepairPartController extends CrmBaseController
{
    public function index()
    {
        $items = TypeRepairPart::all();
        return view('main.typeRepairPart.showAll', compact(['items']));
    }

    public function show($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeRepairPart::find($id);
        if (!$item) {
            abort('404');
        }
        return view('main.typeRepairPart.show', compact(['item']));
    }

    public function create()
    {
        return view('main.typeRepairPart.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->repairPartValidator($request, true)) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $name        = (string)$request->repairpartname;
        $price       = $request->price;
        $infinity    = (int)$request->infinity;
        $quantity    = $infinity? 1 : $request->quantity;
        $selfpart    = (int)$request->selfpart;
        $sales       = $request->sales;
        $main        = (int)$request->main;
        $priority    = (int)($request->priority??15);
        $comment     = (string)$request->comment;
        $description = (string)$request->description;
        try {
            TypeRepairPart::create([
                'name'        => $name,
                'price'       => $price,
                'quantity'    => $quantity,
                'infinity'    => $infinity,
                'sales'       => $sales,
                'selfpart'    => $selfpart,
                'main'        => $main,
                'priority'    => $priority,
                'description' => $description,
                'comment'     => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления материала');
        }
        return redirect()->route('typerepairparts.index')->with('message', 'Материал добавлен');
    }

    public function edit($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeRepairPart::find($id);
        if (!$item) {
            abort('404');
        }
        $edit = 1;
        return view('main.typeRepairPart.addUpdate', compact('item', 'edit'));

    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeRepairPart::find($id);
        if (!$item) {
            abort('404');
        }
        if ($validator = $this->repairPartValidator($request, $id)) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $name        = (string)$request->repairpartname;
        $price       = $request->price;
        $infinity    = (int)$request->infinity;
        $quantity    = $infinity? 1 : $request->quantity;
        $priority    = (int)($request->priority??15);
        $main        = (int)$request->main;
        $selfpart    = (int)$request->selfpart;
        $sales       = $request->sales;
        $comment     = (string)$request->comment;
        $description = (string)$request->description;
        $item = $item->update([
                    'name'        => $name,
                    'price'       => $price,
                    'quantity'    => $quantity,
                    'infinity'    => $infinity,
                    'priority'    => $priority,
                    'main'        => $main,
                    'sales'       => $sales,
                    'selfpart'    => $selfpart,
                    'description' => $description,
                    'comment'     => $comment,
                ]);
        if ($item) {
            return redirect()->route('typerepairparts.index')->with('message', 'Материал обновлен');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления материала');
    }

    public function destroy($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeRepairPart::find($id);
        if (!$item) {
            abort('404');
        }
        try {
            $item->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Материал закреплен за одним из заказов');
        }
        return redirect()->route('typerepairparts.index')->with('message', 'Материал удален');
    }

    public function repairPartValidator($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'repairpartname' => 'required|string|max:50',
            'price'          => 'required|numeric|regex:/^\d{1,10}(\.\d{1,2})?$/',
            'quantity'       => 'exclude_if:infinity,1|nullable|numeric|min:0|max:50000|regex:/^\d{1,7}(\.\d{1,2})?$/',
            'infinity'       => 'nullable|numeric|max:1',
            'priority'       => 'nullable|numeric|min:1|max:5000',
            'main'           => 'nullable|numeric|max:1',
            'sales'          => 'nullable|numeric|min:0|max:50000|regex:/^\d{1,7}(\.\d{1,2})?$/',
            'selfpart'       => 'nullable|numeric|max:1',
            'discription'    => 'nullable|string|max:200',
            'comment'        => 'nullable|string|max:200',
        ]);
        $request = (string)$request->repairpartname;
        $validator = $this->baseNameValidator($validator, 'repairpartname', 'TypeRepairPart', $request, $id);
        return $validator->fails() ? $validator : false;
    }
}
