<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Supplier;
use Faker\Generator as Faker;

$factory->define(Supplier::class, function (Faker $faker) {
    return [
        'company_id' => 1,
        'user_id' => 1,
        'name' => $faker->company,
        'address' => $faker->address,
        'phone_number' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'description' => $faker->paragraph(4),
    ];
});
