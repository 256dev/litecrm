<?php

use App\Models\TypeDevice;
use Illuminate\Database\Seeder;

class TypeDeviceTableSeeder extends Seeder
{
    protected $typeDevices = [
        'Ноутбук',
        'Системный блок',
        'Моноблок',
        'Монитор',
        'Зарядное устройство',
        'Блок питания',
        'Видеокарта',
        'Жёсткий диск',
        'Оперативная память',
        'Сетевая карта',
        'Звуковая карта',
        'Материнская плата',
        'Процессор',
        'Телефон',
        'Планшет',
    ];
    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->typeDevices as $item){
            TypeDevice::insert([
                'name'    => $item,
                'main'     => 1,
                'priority' => 1,
                'comment' => "{$item} comment",
            ]);    
        }
    }
}
