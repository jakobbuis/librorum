<?php

use App\Notebook;
use Faker\Generator as Faker;

$factory->define(Notebook::class, function (Faker $faker) {
    return [
        'slug' => $faker->unique()->regexify('/[A-Z]{2}/'),
        'page_count' => $faker->numberBetween(30, 200),
    ];
});
