<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Wallet;
use Faker\Generator as Faker;

$factory->define(Wallet::class, function (Faker $faker) {
    return [
        'public_key' => $faker->shuffle('0X972A2DA1F9D1DC0B01D313E58FFE916BB5E9A2C1'),
//        'euro_balance' => $faker->numberBetween($min = 30, $max = 480),
        'user_id' => $faker->numberBetween($min = 1, $max = 21),
    ];
});
