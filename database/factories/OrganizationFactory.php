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
        'field_of_work' => 'We work to better understand and leverage domestic philantropy for the social transformation of the countries of the Western Balkans',
//        $faker->sentence(15, true),
        'description' => $faker->paragraph(7, true),
    ];
});
