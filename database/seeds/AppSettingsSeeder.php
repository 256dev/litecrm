<?php

use Illuminate\Database\Seeder;
use App\Models\AppSettings;

class AppSettingsSeeder extends Seeder
{
    public $repair_conditions = '
            1.Сервисный центр устраняет только заявленные неисправности
            2.Оборудование с согласия клиента, принято без разборки и проверки неисправностей, без проверки внутренних повреждений. Клиент согласен, что все неисправности и внутренние повреждения, которые могут быть обнаружены в оборудовании при его техническом обслуживании, возникли до приема оборудования по данной квитанции.
            3.Сданное в ремонт оборудование должно быть получено в течениитридцати дней после извещения по готовности';
            
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        AppSettings::insert([
            'name'       => 'Сервисный центр "LiteCRM"',
            'legal_name' => 'ФЛП LiteCRM',
            'phones'     => json_encode([
                                ['+380999999999', 0, 0, 0],
                                ['+380999999999', 0, 0, 0],
                            ]),
            'email'      => 'admin@litecrm.online',
            'address'    => 'г. Горловка, ул. Пионерская 11',
            'unitcode'   => 'LITE',
            'currency'   => '$',
            'repair_conditions' => $this->repair_conditions,
        ]);
    }
}
