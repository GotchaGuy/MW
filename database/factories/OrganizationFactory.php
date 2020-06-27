<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'title' => $faker->company(),
        'location' => $faker->city(),
        'user_id' => $faker->numberBetween(12, 21),
//        'field-of-work' => $faker->catchPhrase(),
    ];
});
