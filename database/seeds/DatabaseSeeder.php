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
        // Create my personal user
        $email = env('ADMIN_USER_EMAIL', false);
        $password = env('ADMIN_USER_PASSWORD', false);
        if (!$email || !$password) {
            throw new \Exception('You must set admin credentials in .env before seeding');
        }
        $jakob = factory(App\User::class)->create([
            'name' => 'Jakob Buis',
            'email' => $email,
            'password' => bcrypt($password),
        ]);

        // Create the frontend as password-grant client
        $client = (new \Laravel\Passport\Client)->forceFill([
            'user_id' => $jakob->id,
            'name' => 'librorum-frontend',
            'secret' => str_random(40),
            'redirect' => env('APP_URL'),
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false,
        ]);
        $client->save();

        // Create the content
        $tags = factory(\App\Tag::class, 5)->create(['user_id' => $jakob->id]);

        // Create 5 notebooks, each with 3 pages
        // each linked to 2 randomly selected tags
        $notebooks = factory(\App\Notebook::class, 5)->create(['user_id' => $jakob->id]);
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
