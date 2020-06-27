<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Campaign;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Campaign::class, function (Faker $faker) {
    return [
        'title' => $faker->words($nb = 2, $asText = true),
        'euro_goal' => $faker->numberBetween($min = 30000, $max = 120000),
        'start' => $faker->dateTimeBetween($startDate = '-3 months', $endDate = '-1 month', $timezone = null),
        'end' => $faker->dateTimeBetween($startDate = '+1 week', $endDate = '+1 month', $timezone = null),
        'image' => 'https://source.unsplash.com/random/600x950',
        'description' => $faker->paragraph(7, true),
        'overhead' => $faker->numberBetween($min = 0, $max = 20),
        'user_id' => $faker->numberBetween($min = 12, $max = 21),
        //sredi ovo za role i kampanju juzere
        'category_id' => $faker->numberBetween($min = 1, $max = 3),
        'organization_id' => $faker->numberBetween($min = 1, $max = 7),
//        'following' => $faker->boolean($chanceOfGettingTrue = 10),
    ];
});
