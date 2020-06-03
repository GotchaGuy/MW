<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'body' => $faker->paragraph(7, true),
        'image' => 'https://source.unsplash.com/random/523x313',
        'campaign_id' => $faker->numberBetween(1, 15),
    ];
});
