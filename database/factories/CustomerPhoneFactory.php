<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\CustomerPhone;
use Faker\Generator as Faker;

$factory->define(CustomerPhone::class, function (Faker $faker) {
    return [
        'customer_id' => rand(1,8),
        'phone'       => $faker->numerify('#############'),
        'telegram'    => rand(0,1),
        'viber'       => rand(0,1),
        'whatsapp'    => rand(0,1),
    ];
});