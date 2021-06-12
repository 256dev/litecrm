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
            [
                'name'       => 'Администратор',
                'role_id'    => 1,
                'phones'     => json_encode([
                                    ['+380999999999', 0, 0, 0],
                                    ['+380998888888', 0, 0, 0],
                                ]),
                'email'      => 'administrator@litecrm.online',
                'hired_date' => Date::now(),
                'password'   => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Менеджер',
                'role_id'    => 2,
                'phones'     => json_encode([
                                    ['+380999999999', 0, 0, 0],
                                    ['+380998888888', 0, 0, 0],
                                ]),
                'email'      => 'manager@litecrm.online',
                'hired_date' => Date::now(),
                'password'   => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Приемщик',
                'role_id'    => 3,
                'phones'     => json_encode([
                                    ['+380999999999', 0, 0, 0],
                                    ['+380998888888', 0, 0, 0],
                                ]),
                'email'      => 'operator@litecrm.online',
                'hired_date' => Date::now(),
                'password'   => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Мастер',
                'role_id'    => 4,
                'phones'     => json_encode([
                                    ['+380999999999', 0, 0, 0],
                                    ['+380998888888', 0, 0, 0],
                                ]),
                'email'      => 'master@litecrm.online',
                'hired_date' => Date::now(),
                'password'   => bcrypt('password'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // [
            //     'name'       => 'Стажер',
            //     'role_id'    => 6,
            //     'phones'     => json_encode([
            //                         ['+380999999999', 0, 0, 0],
            //                         ['+380998888888', 0, 0, 0],
            //                     ]),
            //     'email'      => 'trainee@litecrm.online',
            //     'hired_date' => Date::now(),
            //     'password'   => bcrypt('password'),
            //     'created_at' => now(),
            //     'updated_at' => now(),
            // ],
        ]);
    }
}
