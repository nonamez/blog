<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

use App\Models;

class BlogPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models\Blog\Posts\Post::factory(50)->has(Models\Blog\Posts\Translated::factory(3)->state(new Sequence(
            ['locale' => 'en'],
            ['locale' => 'lt'],
            ['locale' => 'ru'],
        )), 'translations')->create();
    }
}
