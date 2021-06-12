<?php

namespace App\Http\Controllers\CRM;

use App\Models\AppSettings;
use App\Models\User;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingController extends CrmBaseController
{
    public function show($id = 1)
    {
        $unit_id = (int)$id;
        $item = AppSettings::find($unit_id);

        $this->authorize('view', $item);

        if (!$item) {
            abort('404');
        }
        $phones = json_decode($item->phones);
        return view('main.settings.app', compact(['item', 'phones']));
    }

    public function update(Request $request, $id = 1)
    {
        $unit_id = (int)$id;
        $item = AppSettings::find($unit_id);
        if (!$item) {
            abort('404');
        }

        $this->authorize('update', $item);

        $validator = Validator::make($request->all(), [
            'companyname'       => 'required|string|max:100',
            'legalname'         => 'nullable|string|max:100',
            'email'             => 'required|email|max:100',
            'address'           => 'nullable|string|max:256',
            'unitcode'          => 'required|string|min:2|max:4',
            'currency'          => 'required|string|min:1|max:3',
            'repair_conditions' => 'nullable|string|max:3000',
        ]);
        $validator = $this->basePhonesValidator($request, $validator, 2);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $phones = [];
        for ($i = 1; $i < 3; $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                    $telegram = isset($request["telegram${i}"]) ? 1 : 0;
                    $viber    = isset($request["viber${i}"]) ? 1 : 0;
                    $whatsapp = isset($request["whatsapp${i}"]) ? 1 : 0;
                    $phones[] = [$phone, $telegram, $viber, $whatsapp];
                }
        }
        $item->phones            = json_encode($phones);
        $item->email             = strip_tags($request->email);
        $item->name              = strip_tags($request->companyname);
        $item->legal_name        = strip_tags($request->legalname);
        $item->address           = strip_tags($request->address);
        $item->unitcode          = strtoupper(strip_tags($request->unitcode));
        $item->currency          = strip_tags($request->currency);
        $item->repair_conditions = strip_tags($request->repair_conditions);
        $item = $item->save();
        if ($item) {
            session(['currency' => strip_tags($request->currency)]);
            session(['unitcode' => strtoupper(strip_tags($request->unitcode))]);
            return redirect()->back()->with('message', 'Настройки обновлены');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления настроек');
    }

    public function showUserSettings()
    {
        $user_id = (int)Auth::user()->id;
        $item = User::find($user_id);

        $this->authorize('view', $item);

        $phones = json_decode($item->phones);
        return view('main.settings.user', compact('item', 'phones'));
    }

    public function updateUserSettings(Request $request)
    {
        $user_id = (int)Auth::user()->id;
        $item = User::find($user_id);
        if (!$item) {
            abort('404');
        }
        $old_email = $item->email;
        $validator = Validator::make($request->all(), [
            'selfname' => 'required|string|max:50',
            'email'    => 'required|email|max:100',
            'password' => 'nullable|confirmed|min:8',
        ]);
        $validator->sometimes('email', 'unique:users', function($input) use ($old_email) {
                return $input->email != $old_email;
        });
        $validator = $this->basePhonesValidator($request, $validator, 2);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        }
        $phones = [];
        for ($i = 1; $i < 3; $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                    $telegram = isset($request["telegram${i}"]) ? 1 : 0;
                    $viber    = isset($request["viber${i}"]) ? 1 : 0;
                    $whatsapp = isset($request["whatsapp${i}"]) ? 1 : 0;
                    $phones[] = [$phone, $telegram, $viber, $whatsapp];
                }
        }
        $item->phones = json_encode($phones);
        $item->email  = strip_tags($request->email);
        $item->name   = strip_tags($request->selfname);
        if ($request->password) {
            $item->password = Hash::make($request->password);
        }
        $item = $item->save();
        if ($item) {
            return redirect()->back()->with('message', 'Профиль обновлен');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка обновления профиля');
    }
}
