<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use Faker\Generator as Faker;

$factory->define(Brand::class, function (Faker $faker) {
    return [
        'name' => $faker->company,
        'address' => $faker->address,
        'phone' => $faker->phoneNumber,
        'email' => $faker->companyEmail,
        'description' => $faker->paragraph(4),
        'company_id' => 1,
        'user_id' => 1,
    ];
});
