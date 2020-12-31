<?php

namespace App\Http\Controllers\CRM;

use App\Models\TypeService;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Log;

class TypeServiceController extends CrmBaseController
{
    public function index()
    {
        $items = TypeService::all();
        return view('main.typeService.showAll', compact(['items']));
    }

    public function show($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeService::find($id);
        if (!$item) {
            abort('404');
        }
        return view('main.typeService.show', compact(['item']));
    }

    public function create()
    {
        return view('main.typeService.addUpdate');
    }

    public function store(Request $request)
    {
        if ($validator = $this->serviceValidator($request)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name        = (string)$request->servicename;
        $price       = $request->price;
        $main        = (int)$request->main;
        $priority    = (int)($request->priority??15);
        $comment     = (string)$request->comment;
        $description = (string)$request->description;
        try {
            TypeService::create([
                'name'        => $name,
                'main'        => $main,
                'price'       => $price,
                'priority'    => $priority,
                'description' => $description,
                'comment'     => $comment,
            ]);
        } catch (QueryException $e) {
            Log::error($e);
            return redirect()->back()->withInput()->withErrors('Ошибка добавления услуги');
        }
        return redirect()->route('typeservices.index')->with('message', 'Услуга добавлена');
    }

    public function edit($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeService::find($id);
        if (!$item) {
            abort('404');
        }
        $edit = 1;
        return view('main.typeService.addUpdate', compact('item', 'edit'));

    }

    public function update(Request $request, $id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeService::find($id);
        if (!$item) {
            abort('404');
        }
        if ($validator = $this->serviceValidator($request, $id)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }
        $name        = (string)$request->servicename;
        $main        = (int)$request->main;
        $price       = $request->price;
        $priority    = (int)($request->priority??15);
        $comment     = (string)$request->comment;
        $description = (string)$request->description;
        $item = $item->update([
                    'name'        => $name,
                    'main'        => $main,
                    'price'       => $price,
                    'priority'    => $priority,
                    'description' => $description,
                    'comment'     => $comment,
                ]);
        if ($item) {
            return redirect()->route('typeservices.index')->with('message', 'Услуга обновлена');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления услуги');
    }

    public function destroy($id)
    {
        $id = (int)$id;
        if (!$id) {
            abort('404');
        }
        $item = TypeService::find($id);
        if (!$item) {
            abort('404');
        }
        try {
            $item->delete();
        } catch (QueryException $e) {
            return redirect()->back()->withErrors('Услуга закреплена за одним из заказов');
        }
        return redirect()->route('typeservices.index')->with('message', 'Услуга удалена');
    }

    public function serviceValidator($request, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            'servicename'  => 'required|string|max:50',
            'main'         => 'nullable|numeric|max:1',
            'priority'     => 'nullable|numeric|min:1|max:5000',
            'price'        => 'required|regex:/^\d{1,10}(\.\d{1,2})?$/',
            'discription'  => 'nullable|string|max:200',
            'comment'      => 'nullable|string|max:200',
        ]);
        $request  = (string)$request->servicename;
        $validator = $this->baseNameValidator($validator, 'servicename', 'TypeService', $request, $id);
        return $validator->fails() ? $validator : false;
    }
}
