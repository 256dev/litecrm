<?php

use App\Models\Defect;
use Illuminate\Database\Seeder;

class DefectTableSeeder extends Seeder
{
    protected $defects = [
        ['Чистка', 1],
        ['Замена ОС', 1],
        ['Греется', 1],
        ['Шумит вентелятор', 1],
        ['Тормозит', 1],
        ['Не загружается ОС', 1],
        ['Не включается', 1],
        ['Не реагирует на кнопку питания', 1],
        ['Реагирует на кнопку', 1],
        ['Нет изображения', 1],
        ['Включается и сразу выключается', 1],
        ['Включается и пропадает изображение', 1],
        ['Мерцает подсветкой', 1],
        ['Не реагирует на кнопку', 1],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->defects as $item) {
            Defect::insert([
                'name'        => $item[0],
                'main'        => $item[1],
            ]);
        }

    }
}
