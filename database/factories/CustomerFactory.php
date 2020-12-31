<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    $all_orders        = rand(1, 5);
    $orders_in_process = rand(1,5);
    $orders_in_process = ($orders_in_process < $all_orders) ? : $orders_in_process = 0;

    return [
        'name'              => $faker->name,
        'email'             => $faker->email(),
        'address'           => $faker->streetAddress,
        'all_orders'        => $all_orders,
        'orders_in_process' => $orders_in_process,
        'comment_about'     => $faker->sentence(),
        // 'ads_campaign'      => $faker->word,
    ];
});
