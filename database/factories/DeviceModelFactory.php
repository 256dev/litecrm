<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DeviceModel;
use Faker\Generator as Faker;

$factory->define(DeviceModel::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'manufacturer_id' => rand(1, 11),
        'type_device_id'  => rand(1, 14),
        'comment'         => $faker->sentence(8),
    ];
});
