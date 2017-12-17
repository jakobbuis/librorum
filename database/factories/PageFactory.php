<?php

use App\Notebook;
use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    // Create varied descriptions
    $wordCount = $faker->numberBetween(2, 10);
    $text = $faker->words($wordCount, true);
    $description = $faker->randomElement([null, $text]);

    return [
        'notebook_id' => function() {
            return factory(Notebook::class)->create()->id;
        },
        'start_number' => $faker->numberBetween(0, 30),
        'end_number' => $faker->numberBetween(31, 42),
        'description' => $description,
    ];
});
