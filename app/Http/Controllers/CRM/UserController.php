<?php

namespace App\Http\Controllers\CRM;

use App\Models\Role;
use App\Models\User;
use Date;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\QueryException;

class UserController extends CrmBaseController
{

    public function __construct() {
        $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        $items = User::join('roles', 'users.role_id', 'roles.id')
                     ->select([
                         'users.id            AS id',
                         'users.name          AS name',
                         'users.phones        AS phones',
                         'users.email         AS email',
                         'users.hired_date    AS hired',
                         'users.fired_date    AS fired',
                         'users.qualification AS qualification',
                         'users.address       AS address',
                         'users.passport      AS passport',
                         'users.itin          AS itin',
                         'users.comment       AS comment',
                         'users.deleted_at    AS deleted',
                         'roles.name          AS role'
                     ])
                     ->withTrashed()
                     ->orderBy('users.deleted_at', 'ASC')
                     ->get();
        return view('main.user.showAll', compact('items'));
    }

    public function show(Request $request, User $user)
    {
        $id = $user->id;
        if (!$id) {
            abort('404');
        }
        $item = User::where('users.id', $id)
                    ->join('roles', 'users.role_id', 'roles.id')
                    ->select([
                        'users.id            AS id',
                        'users.name          AS name',
                        'users.phones        AS phones',
                        'users.email         AS email',
                        'users.hired_date    AS hired',
                        'users.fired_date    AS fired',
                        'users.qualification AS qualification',
                        'users.address       AS address',
                        'users.passport      AS passport',
                        'users.itin          AS itin',
                        'users.comment       AS comment',
                        'roles.name          AS role'
                    ])
                    ->get()
                    ->first();
        if (!$item) {
            abort('404');
        }
        $phones = json_decode($item->phones);
        return view('main.user.show', compact('item', 'phones'));
    }

    public function create()
    {
        $roles = Role::all(['id', 'name']);
        return view('main.user.addUpdate', compact(['roles']));
    }

    public function store(Request $request)
    {
        if ($validator = $this->baseUserValidator($request, true)) {
            return redirect()->back()->withInput()->withErrors($validator);         
        }

        $name           = (string)$request->username;
        $email          = (string)$request->email;
        $password       = (string)$request->password;
        $passport       = (string)$request->passport;
        $address        = (string)$request->address;
        $itin           = (int)$request->itin?(int)$request->itin:null;
        $role_id        = (int)$request->role;
        $hired_date     = Date::parse($request->hired_date)->format('Y-m-d');
        $fired_date     = $request->fired_date? Date::parse($request->fired_date)->format('Y-m-d') : null; 
        $qualification  = (string)$request->qualification;
        $comment        = (string)$request->comment;
        $phones = [];
        for ($i = 1; $i < 3; $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                    $telegram = isset($request["telegram${i}"]) ? 1 : 0;
                    $viber    = isset($request["viber${i}"]) ? 1 : 0;
                    $whatsapp = isset($request["whatsapp${i}"]) ? 1 : 0;
                    $phones[] = [$phone, $telegram, $viber, $whatsapp];
                }
        }
        $phones = json_encode($phones);
        try {
            User::create([
                'name'          => $name,
                'email'         => $email,
                'password'      => Hash::make($password),
                'passport'      => $passport,
                'address'       => $address,
                'itin'          => $itin,
                'role_id'       => $role_id,
                'hired_date'    => $hired_date,
                'fired_date'    => $fired_date,
                'phones'        => $phones,
                'qualification' => $qualification,
                'comment'       => $comment,
            ]);
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withErrors('Ошибка добавления сотрудника');
        }
        return redirect()->route('users.index')->with('message', 'Сотрудника добавлен');
    }

    public function edit(Request $request, User $user)
    {
        $id = $user->id;
        if (!$id) {
            abort('404');
        }
        $item   = User::Find($id);
        if (!$item) {
            abort('404');
        }
        $edit = 1;
        $phones = json_decode($item->phones);
        $roles  = Role::all(['id', 'name']);
        return view('main.user.addUpdate', compact('item', 'edit', 'roles', 'phones'));
    }

    public function update(Request $request, User $user)
    {
        if (!$user->id) {
            abort('404');
        }

        if ($validator = $this->baseUserValidator($request)) {
            return redirect()->back()->withInput()->withErrors($validator);
        }

        $role_id = (int)$request->role;
        if ($user->role_id == 1 && $role_id != 1) {
            $users = User::where('role_id', 1)->where('id', '!=', $user-id)->get(['id']);
            if (!$users->count()) {
                return redirect()->back()->withInput()->withErrors('Ошибка! Должен быть хотя бы один администратор');
            }
        }

        $name           = (string)$request->username;
        $email          = (string)$request->email;
        $passport       = (string)$request->passport;
        $address        = (string)$request->address;
        $itin           = (int)$request->itin?(int)$request->itin:null;
        $hired_date     = Date::parse($request->hired_date)->format('Y-m-d');
        $fired_date     = $request->fired_date? Date::parse($request->fired_date)->format('Y-m-d') : null; 
        $qualification  = (string)$request->qualification;
        $comment        = (string)$request->comment;
        $phones = [];
        for ($i = 1; $i < 3; $i++) {
            if (($phone = (string)$request["phone${i}"]) != null || $i === 1 ) {
                $telegram = isset($request["telegram${i}"]) ? 1 : 0;
                $viber    = isset($request["viber${i}"]) ? 1 : 0;
                $whatsapp = isset($request["whatsapp${i}"]) ? 1 : 0;
                $phones[] = [$phone, $telegram, $viber, $whatsapp];
            }
        }
        $phones = json_encode($phones);
        $user = $user->update([
            'name'          => $name,
            'email'         => $email,
            'passport'      => $passport,
            'address'       => $address,
            'itin'          => $itin,
            'role_id'       => $role_id,
            'hired_date'    => $hired_date,
            'fired_date'    => $fired_date,
            'phones'        => $phones,
            'qualification' => $qualification,
            'comment'       => $comment,
        ]);
        if ($user) {
            return redirect()->route('users.index')->with('message', 'Информация о сотруднике обновлена');
        }
        return redirect()->back()->withErrors('Ошибка обновления информации о сотруднике');
    }

    public function destroy(User $user)
    {
        if (!$user->id) {
            abort('404');
        }

        if ($user->role_id == 1) {
            $users = User::where('role_id', 1)->where('id', '!=', $user->id)->get(['id']);
            if (!$users->count()) {
                return redirect()->back()->withInput()->withErrors('Ошибка! Должен быть хотя бы один администратор');
            }
        }
        $user->fired_date = Date::now()->tz(config('custom.tz'));
        $user->save();
        $user = $user->delete();
        if ($user) {
            return redirect()->route('users.index')->with('message', 'Сотрудник удален');
        }
        return redirect()->back()->withInput()->withErrors('Ошибка!Есть заказы оформленные данным сотрудником');
    }

    public function updatePassword(Request $request, $id)
    {
        if (!$request->ajax()) {
            abort('404');          
        };
        $user_id = (int)$id;
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status'  => 2 ,
                'message' => ['Неверно заполненные поля помечены красным', 'danger'],
                'errors'  => $validator->errors()
            ]);          
        }

        $user = User::find($user_id);
        if ($user) {
            $user->password = Hash::make($request->password);
            $user = $user->save();
            if ($user) {
                return response()->json([
                    'status'  => 1 ,
                    'message' => ['Пароль обновлен', 'success'],
                ]);          
            }
            $error_message = 'Ошибка обновления пароля';       
        }
        $error_message = $error_message ?? 'Такого сотрудника не существует';
        return response()->json([
            'status'  => 3 ,
            'message' => [$error_message, 'danger']
        ]);
        
    }
}
