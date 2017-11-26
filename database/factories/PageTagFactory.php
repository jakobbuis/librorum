<?php

use App\Page;
use App\Tag;
use Faker\Generator as Faker;

$factory->define(PageTag::class, function (Faker $faker) {
    return [
        'tag_id' => function () {
            return factory(Tag::class)->create()->id;
        },
        'page_id' => function () {
            return factory(Page::class)->create()->id;
        },
    ];
});
