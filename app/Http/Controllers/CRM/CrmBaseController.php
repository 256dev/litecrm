<?php

namespace App\Http\Controllers\CRM;

use App\Models\Defect;
use App\Models\Condition;
use App\Models\Equipment;
use App\Models\TypeDevice;
use App\Models\TypeService;
use App\Models\Manufacturer;

use Validator;
use App\Http\Controllers\Controller;
use App\Models\TypeRepairPart;

class CrmBaseController extends Controller
{
    public function baseUserValidator($request, $create = false)
    {
        $email_validator = $create ? 'required|email|max:100|unique:users':'required|email|max:100';
        $validator = Validator::make($request->all(), [
            'username'      => 'required|string|max:50',
            'email'         => $email_validator,
            'passport'      => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:100',
            'itin'          => 'nullable|digits_between:8,12',
            'role'          => 'required|exists:roles,id',
            'hired_date'    => 'required|date',
            'fired_date'    => 'nullable|date',
            'qualification' => 'nullable|string|max:200',
            'comment'       => 'string|max:200|nullable',
        ]);

        $validator = $this->basePhonesValidator($request, $validator);

        return $validator->fails() ? $validator : false;
    }

    public function baseCustomerValidator($request) {
        $validator = $this->baseCustomerInfoValidator($request);
        $validator = $this->basePhonesValidator($request, $validator);

        return $validator->fails() ? $validator : false;
    }

    public function baseOrderValidator($request)
    {
        $validator = Validator::make($request->all(), [
            'customer'      => 'required|exists:customers,id',
            'engineer'      => 'required|exists:users,id',
            'sn'            => 'nullable|string|max:32',
            'model'         => 'required|max:50',
            'manufacturer'  => 'required',
            'typedevice'    => 'required',
            'date_contract' => 'required|date',
            'time_contract' => 'required|date_format:H:i',
            'deadline'      => 'required|digits_between:1,3',
            'urgency'       => 'nullable|numeric|max:1',
            'prepayment'    => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
            'agreed_price'  => 'nullable|regex:/^\d{1,10}(\.\d{1,2})?$/',
            'conditions'    => 'nullable|array',
            'equipments'    => 'nullable|array',
            'defects'       => 'nullable|array',
            'order_comment' => 'nullable|string|max:200',
        ]);
        
        return $validator->fails() ? $validator : false;
    }

    public function baseCustomerInfoValidator($request) 
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:50',
            'email'    => 'nullable|email|max:100',
            'passport' => 'nullable|string|max:20',
            'address'  => 'nullable|string|max:100',
            'comment'  => 'nullable|string|max:200'
        ]);

        return $validator;
    }

    public function basePhonesValidator($request, $validator, $phones = 3) {
        for ($i = 1; $i < ($phones + 1); $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                if (!preg_match('/^\+{0,1}\d{5,13}+$/', $phone)) {
                    $validator->after(function($validator) use ($phone, $i) {
                        $validator->errors()->add("phone{$i}", "Неверно введён номер! {$phone}");
                    });
                } 
            }
        }
        return $validator;
    }

    public function baseInfoValidator($request, $name, $model, $id = 0)
    {
        $validator = Validator::make($request->all(), [
            $name      => 'required|string|max:50',
            'main'     => 'nullable|numeric|max:1',
            'priority' => 'nullable|numeric|min:1|max:5000',
            'comment'  => 'nullable|string|max:200',
        ]);
        $request  = (string)$request->$name;
        $validator = $this->baseNameValidator($validator, $name, $model, $request, $id);
        return $validator->fails() ? $validator : false;
    }

    public function baseNameValidator($validator, $name, $model, $request, $id)
    {
        $model = '\\App\\Models\\' . $model;
        $item  = $model::where('name','LIKE', $request);
        $item  = $item->get(['id']);
        if ($item->count() > 0 && $item->where('id', '!=', (int)$id)->count()) {
            $validator->after(function($validator) use ($name, $request) {
                $validator->errors()->add($name, "Имя '${request}' уже сушествует! ");
            });
        }
        return $validator;
    }

    public function getId($request, $model)
    {
        $request = strip_tags($request);
        $model   = '\\App\\Models\\' . $model;
        if (preg_match('/^new_/', $request)) {
            $request = mb_substr($request, 4);
            $request = mb_substr($request, 0, 50);
            $in_db = $model::where('name', $request);
            if (!$in_db->get(['id'])->count()) {
                $id = $in_db->create(['name' => $request])->id;
            } else {
                $id = (int)$in_db->get(['id'])->first()->id;
            }
        } else {
            $id = (int)$request;
        }
        return $id;
    }
}
