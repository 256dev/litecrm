<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\RepairPart;
use Faker\Generator as Faker;

$factory->define(RepairPart::class, function (Faker $faker) {
    return [
        'type_repairparts_id' => rand(1, 10),
        'order_id'            => rand(1, 15),
        'quantity'            => rand(0, 20),
        'price'               => $faker->randomFloat(2, 10, 2000),
    ];
});
