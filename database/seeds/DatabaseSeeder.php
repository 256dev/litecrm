<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppSettingsSeeder::class);
        $this->call(RolesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(TypeDeviceTableSeeder::class);
        $this->call(ManufacturersTableSeeder::class);
        $this->call(OrderStatusTableSeeder::class);

        // $this->call(DefectTableSeeder::class);
        // $this->call(EquipmentTableSeeder::class);
        // $this->call(ConditionTableSeeder::class);
        // $this->call(TypeServiceTableSeeder::class);

        // factory(App\Models\TypeRepairPart::class, 10)->create();
        // factory(App\Models\DeviceModel::class, 20)->create();
        // factory(App\Models\Customer::class, 15)->create()->each(function($customer) {
        //     for ($i = 0; $i < rand(1, 3); $i++) {
        //         $customer->phone()->save(factory(App\Models\CustomerPhone::class)->make());
        //     }
        // });
        // factory(App\Models\Device::class, 15)->create()->each(function($device) {
        //     $device->order()->save(factory(App\Models\Order::class)->make());
        // });
        // factory(App\Models\Service::class, 25)->create();
        // factory(App\Models\RepairPart::class, 10)->create();
        // factory(App\Models\OrderHistory::class, 15)->create();
    }
}
