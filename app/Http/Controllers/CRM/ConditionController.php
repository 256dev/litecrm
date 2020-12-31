<?php

namespace App\Http\Controllers\CRM;

use App\Models\Condition;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class ConditionController extends CrmBaseController
{
    public function index()
    {
        $items = Condition::all();
        return view('main.condition.showAll', compact(['items']));
    }

    public function show($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Condition::find($id);
        if (!$item) {
            abort('404');
        }
        return view('main.condition.show', compact(['item']));
    }

    public function create()
    {
        return view('main.condition.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseInfoValidator($request, 'conditionname', 'Condition')) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name     = (string)$request->conditionname;
        $main     = (int)$request->main;
        $priority = (int)($request->priority??15);
        $comment  = (string)$request->comment;
        try {
            Condition::create([
                'name'     => $name,
                'main'     => $main,
                'priority' => $priority,    
                'comment'  => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления состояния');
        }
        return redirect()->route('conditions.index')->with('message', 'Состояние добавлено');
    }

    public function edit($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Condition::find($id);
        if (!$item) {
            abort('404');
        }
        $edit = 1;
        return view('main.condition.addUpdate', compact('item', 'edit'));
    }

    public function update(Request $request, $id)
    {
     
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Condition::find($id);
        if (!$item) {
            abort('404');
        }
        if ($validator = $this->baseInfoValidator($request, 'conditionname', 'Condition', $id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }
        $name     = (string)$request->conditionname;
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
            return redirect()->route('conditions.index')->with('message', 'Состояние обновлено');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления состояния');
    }

    public function destroy($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = Condition::find($id);
        if (!$item) {
            abort('404');
        }
        try {
            $item = $item->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Ошибка удаления состояния. Оно закрепеленно за одним из заказов.');
        }
        if ($item) {
            return redirect()->route('conditions.index')->with('message', 'Состояние удалено');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка удаления состояния');
    }

    public function main(Request $request, $id)
    {
        $id = (int)$id;
        if(!$request->ajax() && !$id){
            abort('404');          
        };
        $item = Condition::find($id);
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
        $item = Condition::find($id);
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
