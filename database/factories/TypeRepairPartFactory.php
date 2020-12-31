<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\TypeRepairPart;
use Faker\Generator as Faker;

$factory->define(TypeRepairPart::class, function (Faker $faker) {
    return [
        'name'        => $faker->sentence(3),
        'quantity'    => rand(0, 20),
        'price'       => $faker->randomFloat(2, 10, 2000),
        'main'        => rand(0, 1),
        'priority'    => rand(0, 20),
        'description' => $faker->sentences(3, true),
        'comment'     => $faker->sentences(3, true),
    ];
});
