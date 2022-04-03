<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence,
        'slug' => $faker->slug,
        'featured' => $faker->numberBetween(0, 1),
        'details' => $faker->sentence(8),
        'price' => $faker->numberBetween(20, 1000),
        'description' => $faker->paragraph,
        'image' => 'product.png',
//        'images' => '["laptop-1.jpg","laptop-2.jpg","laptop-3.jpg"]',
        'quantity' => $faker->numberBetween(1, 20),
    ];
});
