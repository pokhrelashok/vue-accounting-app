<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Customer;
use Faker\Generator as Faker;

$factory->define(Customer::class, function (Faker $faker) {
    return [
        'company_id' => 1,
        'user_id' => 1,
        'name' => $faker->name,
        'address' => $faker->address,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->email,
        'description' => $faker->paragraph(4),
        'user_id' => 1,
        'priority' => 0,
        'favorite' => 0,
    ];
});
