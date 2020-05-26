<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Campaign;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'title' => $faker->catchPhrase(),
        'euro_goal' => $faker->numberBetween($min = 30000, $max = 120000),
        'euro_raised' => $faker->numberBetween($min = 7000, $max = 28000),
        'start' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = '-1 month', $timezone = null),
        'end' => $faker->dateTimeBetween($startDate = '+1 week', $endDate = '+1 month', $timezone = null),
        'description' => $faker->paragraph(7, true),
        'user_id' => $faker->numberBetween($min = 2, $max = 21),
    ];
});
