<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'contact_details' => $faker->phoneNumber,
        'price' => $faker->randomFloat(2, 2500, 10000),
    ];
});
