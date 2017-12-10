<?php

use App\Notebook;
use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    return [
        'notebook_id' => function() {
            return factory(Notebook::class)->create()->id;
        },
        'start_number' => $faker->numberBetween(0, 30),
        'end_number' => $faker->numberBetween(31, 42),
        'description' => $faker->text,
    ];
});
