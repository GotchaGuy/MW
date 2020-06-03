<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Organization;
use Faker\Generator as Faker;

$factory->define(Organization::class, function (Faker $faker) {
    return [
        'title' => $faker->company(),
        'location' => $faker->city(),
//        'field-of-work' => $faker->catchPhrase(),
    ];
});
