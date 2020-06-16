<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Follow;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Follow::class, function (Faker $faker) {
    return [
        'campaign_id' => $faker->numberBetween($min = 1, $max = 15),
        'user_id' => $faker->numberBetween($min = 1, $max = 21),
    ];
});
