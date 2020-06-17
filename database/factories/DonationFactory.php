<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Donation;
use App\Model;
use Faker\Generator as Faker;

$factory->define(Donation::class, function (Faker $faker) {
    return [
        'euro_amount' => $faker->numberBetween($min = 1000, $max = 8000),
        'plan_b' => $faker->numberBetween($min = 1, $max = 3),
        'user_id' => $faker->numberBetween($min = 2, $max = 21),
        'campaign_id' => $faker->numberBetween($min = 1, $max = 11),
    ];
});
