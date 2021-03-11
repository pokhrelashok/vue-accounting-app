<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Brand;
use App\Category;
use App\Product;
use App\Unit;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'company_id' => 1,
        'name' => $faker->city,
        'category_id' => Category::inRandomOrder()->first()->id,
        'brand_id' => Brand::inRandomOrder()->first()->id,
        'description' => $faker->sentence(6),
        'user_id' => 1,
        'unit_id' => Unit::inRandomOrder()->first()->id
    ];
});
