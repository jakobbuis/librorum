<?php

use App\Tag;
use Faker\Generator as Faker;

$factory->define(Tag::class, function (Faker $faker) {
    return [
        'tag' => $faker->unique()->word,
        'starred' => $faker->boolean,
    ];
});
