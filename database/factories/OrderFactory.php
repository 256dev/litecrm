<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Order;
use App\Models\AppSettings;
use Date AS Currentdate;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    $unitcode = AppSettings::find(1)->get()->first()->unitcode;
    $number   = $unitcode . Currentdate::now()->tz(config('custom.tz'))->format('YmdHis');
    return [
        'number'             => $number,
        'customer_id'        => rand(1, 8),
        'inspector_id'       => 1,
        'engineer_id'        => 1,
        'device_id'          => 1,
        'date_contract'      => $faker->date(),
        'deadline'           => rand(1, 30),
        'urgency'            => rand(0, 1),
        'prepayment'         => $faker->randomFloat(2, 0, 1000),
        'agreed_price'       => 0,
        'order_comment'      => $faker->sentence(),
        'last_history_id'    => rand(1, 15),
    ];
});
