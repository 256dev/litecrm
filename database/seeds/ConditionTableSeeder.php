<?php

use App\Models\Condition;
use Illuminate\Database\Seeder;

class ConditionTableSeeder extends Seeder
{
    protected $conditions = [
        ['Сколы', 1],
        ['Потертости', 1],
        ['Не работает клавиатура', 1],
        ['Не работает тачпад', 1],
        ['Нет звука', 1],
        ['Переломан шнур на блоке', 1],
        ['Не хватает клавиш', 1],
        ['Не работают USB', 1],
        ['Не работает камера', 1],
        ['Не хватает крышек', 1],
        ['Нет боковый крышки', 1],
        ['Сломана лицевая панель', 1],
        ['Сломана правая петля', 1],
        ['Сломана левая петля', 1],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->conditions as $item) {
            Condition::insert([
                'name'        => $item[0],
                'main'        => $item[1],
            ]);
        }

    }
}
