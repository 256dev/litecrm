<?php

namespace App\Http\Controllers\CRM;

use App\Models\Equipment;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class EquipmentController extends CrmBaseController
{
    public function __construct() {
        $this->authorizeResource(Equipment::class, 'equipment');
    }

    public function index()
    {
        $items = Equipment::all();
        return view('main.equipment.showAll', compact(['items']));
    }

    public function show(Equipment $equipment)
    {
        if (!$equipment->id) {
            abort('404');
        }

        return view('main.equipment.show', ['item' => $equipment]);
    }

    public function create()
    {
        return view('main.equipment.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseInfoValidator($request, 'equipmentname', 'Equipment')) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $name     = (string)$request->equipmentname;
        $main     = (int)$request->main;
        $priority = (int)($request->priority??15);
        $comment  = (string)$request->comment;
        try {
            Equipment::create([
                'name'     => $name,
                'main'     => $main,
                'priority' => $priority,    
                'comment'  => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления комплектации');
        }
        return redirect()->route('equipments.index')->with('message', 'Комплектация добавлена');
    }

    public function edit(Equipment $equipment)
    {
        if (!$equipment->id) {
            abort('404');
        }

        $edit = 1;

        return view('main.equipment.addUpdate', ['item' => $equipment, 'edit' => $edit]);
    }

    public function update(Request $request, Equipment $equipment)
    {
     
        if (!$equipment->id) {
            abort('404');
        }

        if ($validator = $this->baseInfoValidator($request, 'equipmentname',  'Equipment', $equipment->id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name     = (string)$request->equipmentname;
        $main     = (int)$request->main;
        $priority = (int)($request->priority ?? 15);
        $comment  = (string)$request->comment;
        $equipment = $equipment->update([
                    'name'     => $name,
                    'main'     => $main,
                    'priority' => $priority,    
                    'comment'  => $comment,
                ]);
        if ($equipment) {
            return redirect()->route('equipments.index')->with('message', 'Комплектация обновлена');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления комплектация');
    }

    public function destroy(Equipment $equipment)
    {
        if (!$equipment->id) {
            abort('404');
        }

        try {
            $equipment = $equipment->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Ошибка удаления комплектации. Она закрепленна за одним из заказов.');
        }
        if ($equipment) {
            return redirect()->route('equipments.index')->with('message', 'Комплектация удалена');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка удаления комплектации');
    }

    public function main(Request $request, $id)
    {
        $id = (int)$id;
        if(!$request->ajax() && !$id){
            abort('404');          
        };
        $item = Equipment::find($id);
        if (!$item) {
            abort('404');
        }
        $item->main = (int)$request->main;
        $item = $item->save();
        if ($item) {
            return response()->json([
                'status'      => 1,
                'message'     => ['Значение обновлено', 'success'],
            ]);    
        }
        return response()->json([
            'status'  => 3,
            'message' => ['Ошибка обновления!', 'danger'],
        ]);
    }

    public function priority(Request $request, $id)
    {
        $id = (int)$id;
        if(!$request->ajax() && !$id){
            abort('404');          
        };
        $item = Equipment::find($id);
        if (!$item) {
            abort('404');
        }
        $validator = Validator::make($request->all(), [
            'priority' => 'nullable|numeric|max:5000'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 2 ,
                'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                'errors' => $validator->errors()
            ]);
        }
        $item->priority = (int)$request->priority;
        $item = $item->save();
        if ($item) {
            return response()->json([
                'status'      => 1,
                'message'     => ['Значение обновлено', 'success'],
            ]);    
        }
        return response()->json([
            'status'  => 3,
            'message' => ['Ошибка обновления!', 'danger'],
        ]);
    }
}
