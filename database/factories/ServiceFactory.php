<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Service;
use Faker\Generator as Faker;

$factory->define(Service::class, function (Faker $faker) {
    return [
        'type_service_id' => rand(1, 7),
        'order_id'        => rand(1, 15),
        'quantity'        => 1,
        'price'           => $faker->randomFloat(2, 10, 2000),
    ];
});
