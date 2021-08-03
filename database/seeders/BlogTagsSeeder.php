<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models;

class BlogTagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models\Blog\Tags\Tag::factory(20)->create();
    }
}
