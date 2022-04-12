<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models;

class InvoicesItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models\Invoices\Item::factory(100)->create();
    }
}
