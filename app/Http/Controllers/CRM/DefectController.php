<?php

namespace App\Http\Controllers\CRM;

use App\Models\Defect;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;


class DefectController extends CrmBaseController
{
    public function __construct() {
        $this->authorizeResource(Defect::class, 'defect');
    }

    public function index()
    {
        $items = Defect::all();
        return view('main.defect.showAll', compact(['items']));
    }

    public function show(Defect $defect)
    {
        if (!$defect->id) {
            abort('404');
        }

        return view('main.defect.show', ['item' => $defect]);
    }

    public function create()
    {
        return view('main.defect.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseInfoValidator($request, 'defectname', 'Defect')) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name     = (string)$request->defectname;
        $main     = (int)$request->main;
        $priority = (int)($request->priority??15);
        $comment  = (string)$request->comment;
        try {
            Defect::create([
                'name'     => $name,
                'main'     => $main,
                'priority' => $priority,    
                'comment'  => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления причины обращения');
        }
        return redirect()->route('defects.index')->with('message', 'Причина обращения добавлена');
    }

    public function edit(Defect $defect)
    {
        if (!$defect->id) {
            abort('404');
        }

        $edit = 1;

        return view('main.defect.addUpdate', ['item' => $defect, 'edit' => $edit]);
    }

    public function update(Request $request, Defect $defect)
    {
        if (!$defect->id) {
            abort('404');
        }

        if ($validator = $this->baseInfoValidator($request,'defectname', 'Defect', $defect->id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }
        $name     = (string)$request->defectname;
        $main     = (int)$request->main;
        $priority = (int)($request->priority ?? 15);
        $comment  = (string)$request->comment;
        $defect = $defect->update([
                    'name'     => $name,
                    'main'     => $main,
                    'priority' => $priority,    
                    'comment'  => $comment,
                ]);
        if ($defect) {
            return redirect()->route('defects.index')->withInput()->with('message', 'Причина обращения обновлена');
        }
        return redirect()->back()->withErrors('Ошибка обновления причины обращения');
    }

    public function destroy(Defect $defect)
    {
        if (!$defect->id) {
            abort('404');
        }

        try {
            $defect = $defect->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Ошибка удаления причины обращения. Она закрепленна за одним из заказов.');
        }
        if ($defect) {
            return redirect()->route('defects.index')->withInput()->with('message', 'Причина обращения удалена');
        }
        return redirect()->back()->withErrors('Ошибка удаления причины обращения');
    }

    public function main(Request $request, $id)
    {
        $id = (int)$id;
        if(!$request->ajax() && !$id){
            abort('404');          
        };
        $item = Defect::find($id);
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
        $item = Defect::find($id);
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
