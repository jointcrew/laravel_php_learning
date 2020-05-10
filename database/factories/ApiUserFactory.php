<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\ApiUser;
use Faker\Generator as Faker;

$factory->define(ApiUser::class, function (Faker $faker) {
    return [
        'user_name' => $faker->name,
        'age' => $faker->numberBetween($min = 10, $max = 100),
        'create_user_id' => 1,
        'create_user_name' => 'テスト',
    ];
});
