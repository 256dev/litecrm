<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\OrderHistory;
use Faker\Generator as Faker;

$factory->define(OrderHistory::class, function (Faker $faker) {
    return [
        'created_at' => $faker->date(),
        'order_id'   => rand(1, 15),
        'user_id'    => 1,
        'status_id'  => rand(1, 4),
    ];
});
