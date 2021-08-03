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
        $this->call(UsersSeeder::class);
        $this->call(BlogTagsSeeder::class);
        $this->call(BlogPostsSeeder::class);
        $this->call(InvoiceClientsSeeder::class);
        $this->call(InvoiceInvoicesSeeder::class);
    }
}
