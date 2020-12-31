<?php

use Illuminate\Database\Seeder;
use App\Models\Manufacturer;

class ManufacturersTableSeeder extends Seeder
{
    protected $company_names = [
        'Asus',
        'Asrock',
        'MSI',
        'Gigabyte',
        'Palit',
        'Dell',
        'Lenovo',
        'Toshiba',
        'HP',
        'LG',
        'Acer',
        'Apple',
        'Samsung',
        'Xiaomi',
        'Panasonic',
        'Prestigio',
        'Fujitsu',
        'TP-Linl',
        'DLink',
        'ZyXel',
        'Cisco',
        'WD',
        'Seagate',
        'Transcend',
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->company_names as $name) {
            Manufacturer::insert([
                'name'     => $name,
                'main'     => 1,
                'priority' => 1,
                'comment'  => "{$name} comment",
            ]);    
        }
    }
}
