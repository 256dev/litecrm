<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    protected $roles = [
        ['Администратор', 'admin'],
        ['Директор', 'director'],
        ['Менеджер', 'manager'],
        ['Оператор', 'operator'],
        ['Мастер', 'master'],
        ['Стажер', 'trainee'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->roles as $item) {
            Role::insert([
                'name'        => $item[0],
                'slug'        => $item[1],
            ]);
        }
    }
}
