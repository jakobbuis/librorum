<?php

use App\Notebook;
use App\Page;
use Faker\Generator as Faker;

$factory->define(Page::class, function (Faker $faker) {
    $notebook = factory(Notebook::class)->create();
    $start = $faker->numberBetween(0, $notebook->page_count);
    $end = $faker->numberBetween($start, $notebook->page_count);

    return [
        'notebook_id' => $notebook->id,
        'start_number' => $start,
        'end_number' => $end,
        'description' => $faker->text,
    ];
});
