<?php

use App\Models\Equipment;
use Illuminate\Database\Seeder;

class EquipmentTableSeeder extends Seeder
{
    protected $equipments = [
        ['Ноутбук', 1],
        ['Зарядное', 1],
        ['Мышка', 1],
        ['Сумка', 1],
        ['Монитор', 1],
        ['Провод питания', 1],
        ['Коробка с документами', 1],
        ['Шнур VGA', 1],
        ['Шнур DVI', 1],
        ['Шнур HDMI', 1],
        ['Системный блок', 1],
        ['Блок питания', 1],
        ['Клавиатура', 1],
        ['Роутер', 1],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->equipments as $item) {
            Equipment::insert([
                'name'        => $item[0],
                'main'        => $item[1],
            ]);
        }

    }
}
