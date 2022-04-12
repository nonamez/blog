<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models;

class InvoiceClientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models\Invoices\Client::factory(30)->create();
    }
}
