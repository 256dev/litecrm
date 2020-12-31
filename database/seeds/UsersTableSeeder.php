<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Jenssegers\Date\Date;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::insert([
            'name'       => 'Администратор',
            'role_id'    => 1,
            'phones'     => json_encode([
                                ['+380999999999', 0, 0, 0],
                                ['+380998888888', 0, 0, 0],
                            ]),
            'email'      => 'administrator@litecrm.online',
            'hired_date' => Date::now(),
            'password'   => bcrypt('789456123'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
