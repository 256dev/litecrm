<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Device;
use Faker\Generator as Faker;

$factory->define(Device::class, function (Faker $faker) {
    return [
        'device_model_id' => rand(1, 11),
        'SN'              => substr($faker->md5(), 0, 17),
        'comment'         => $faker->sentence(),
    ];
});
