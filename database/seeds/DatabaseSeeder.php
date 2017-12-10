<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = factory(\App\Tag::class, 5)->create();

        // Create 5 notebooks, each with 3 pages
        // each linked to 2 randomly selected tags
        $notebooks = factory(\App\Notebook::class, 5)->create();
        $notebooks->each(function($notebook) use ($tags) {

            $pages = factory(\App\Page::class, 3)->create([
                'notebook_id' => $notebook->id,
            ]);

            $pages->each(function($page) use ($tags) {
                $page->tags()->attach($tags->random(2));
            });
        });
    }
}
