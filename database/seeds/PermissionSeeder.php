<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    protected $permissions = [
        ['Просмотр сотрудников', 'view-users'],
        ['Создание/редактирование сотрудников', 'store-user'],
        ['Удаление сотрудника', 'delete-user'],

        ['Просмотр заказов', 'view-orders'],
        ['Создание/редактирование заказов', 'store-order'],
        ['Удаление заказа', 'delete-order'],

        ['Просмотр клиентов', 'view-customers'],
        ['Создание/редактирование клиентов', 'store-customer'],
        ['Удаление клиента', 'delete-customer'],

        ['Просмотр настроек', 'view-settings'],
        ['Создание/редактирование сотрудников', 'store-settings'],

        ['Просмотр устройств', 'view-devices'],
        ['Создание/редактирование устройств', 'store-device'],
        ['Удаление устройства', 'delete-device'],

        ['Просмотр типов устройств', 'view-type_devices'],
        ['Создание/редактирование типов устройств', 'store-type_devices'],
        ['Удаление типа устройства', 'delete-type_devices'],

        ['Просмотр брендов', 'view-manufacturers'],
        ['Создание/редактирование брендов', 'store-manufacturer'],
        ['Удаление бренда', 'delete-manufacturer'],

        ['Просмотр услуг', 'view-services'],
        ['Создание/редактирование услуг', 'store-service'],
        ['Удаление услуги', 'delete-service'],

        ['Просмотр материалов', 'view-repair_parts'],
        ['Создание/редактирование материалов', 'store-repair_part'],
        ['Удаление материала', 'delete-repair_part'],

        ['Просмотр причин обращения', 'view-defects'],
        ['Создание/редактирование причин обращения', 'store-defect'],
        ['Удаление причины обращения', 'delete-defect'],

        ['Просмотр состояния устройства', 'view-conditions'],
        ['Создание/редактирование состояния устройства', 'store-condition'],
        ['Удаление состояния устройства', 'delete-condition'],

        ['Просмотр комплектаций', 'view-equipments'],
        ['Создание/редактирование комплектаций', 'store-equipment'],
        ['Удаление комплектации', 'delete-equipment'],

        ['Генерация отчета', 'create-report'],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->permissions as $item) {
            Permission::insert([
                'name' => $item[0],
                'slug' => $item[1],
            ]);
        }
    }
}
