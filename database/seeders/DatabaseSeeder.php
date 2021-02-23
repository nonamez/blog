<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	$status = ['published', 'draft', 'hidden'];

    	Models\Blog\Tags\Tag::factory(20)->create();

        Models\Users\User::factory(10)->has(Models\Blog\Posts\Post::factory(rand(1,5))->has(Models\Blog\Posts\Translated::factory(3)->state(new Sequence(
            ['locale' => 'en'],
            ['locale' => 'lt'],
            ['locale' => 'ru'],
        )), 'translations'))->create();
    }
}
