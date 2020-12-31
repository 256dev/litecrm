<?php

use App\Models\TypeService;
use Illuminate\Database\Seeder;

class TypeServiceTableSeeder extends Seeder
{
    protected $type_service = [
        ['Чистка ноутбука', 0, 1, 1, 'Полчная разборка ноутбука'],
        ['Замена ОС', 0, 1, 1, 'Переустановка ОС с полным набором драйверов и базовым ПО'],
        ['Чистка системного блока', 0, 1, 1, 'Полчная разборка системного блока'],
        ['Ремонт блока питания', 0, 1, 1, 'Ремонт блока питания без учета запчастей'],
        ['Ремонт монитора', 0, 1, 1, 'Ремонт монитора без учета запчастей'],
        ['Диагностика ноутбука (без разобрки)', 0, 1, 1, 'Диагностика без полной разборки ноутбука'],
        ['Диагностика ноутбука (с разобркой)', 0, 1, 1, 'Диагностика с полной разборкой ноутбука'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->type_service as $item) {
            TypeService::insert([
                'name'        => $item[0],
                'price'       => $item[1],
                'main'        => $item[2],
                'priority'    => $item[3],
                'description' => $item[4],
            ]);
        }
    }
}
