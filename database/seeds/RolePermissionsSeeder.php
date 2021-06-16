<?php

use Illuminate\Database\Seeder;
use App\Models\RolePermission;

class RolePermissionsSeeder extends Seeder
{
    protected $rolesPermissions = [
        // Manager
        [2, 4], [2, 5], [2, 6], [2, 7], [2, 8], [2, 9], [2, 10], [2, 11], [2, 12], [2, 13], [2, 14], [2, 15], [2, 16], [2, 17],
        [2, 18], [2, 19], [2, 20], [2, 21], [2, 22], [2, 23], [2, 24], [2, 25], [2, 26], [2, 27], [2, 28], [2, 29], [2, 30], [2, 31],
        [2, 32], [2, 33], [2, 34], [2, 35], [2, 36],

        // Operator
        [3, 7], [3, 8], [3, 9], [3, 4], [3, 5], [3, 6],

        // Master
        [4, 24], [4, 5], [4, 4],

        // Trainee
        // [6, 4],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rolesPermissions as $item) {
            RolePermission::insert([
                'role_id' => $item[0],
                'permission_id' => $item[1],
            ]);
        }
    }
}
