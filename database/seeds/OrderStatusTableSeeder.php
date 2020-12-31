<?php

use Illuminate\Database\Seeder;
use App\Models\OrderStatus;

class OrderStatusTableSeeder extends Seeder
{
    protected $order_status = [
                    'Оформлен' => 'primary',
                    'В работе' => 'secondary',
                    'На паузе' => 'warning text-dark',
                    'К выдаче' => 'info',
                    'Выдан'    => 'success',
                    'Закрыт'   => 'danger',
                ];

    public function run()
    {
        foreach ($this->order_status as $status => $color) {
            OrderStatus::insert([
                'name'  => $status,
                'color' => $color,
            ]);
        }
    }
}
