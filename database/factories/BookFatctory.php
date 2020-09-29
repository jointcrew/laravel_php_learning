<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;

$factory->define(Book::class, function (Faker $faker) {
    return [
        'author' => $faker->name,
        'title' => $faker->title . $faker->randomNumber() . $faker->time(),
        'description' => $faker->paragraph,
        'status' => $faker->numberBetween(1, 2),
        'rent_count' => $faker->randomNumber()
    ];
});
