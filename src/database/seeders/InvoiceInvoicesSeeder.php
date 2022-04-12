<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models;

class InvoiceInvoicesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Models\Invoices\Invoice::factory(50)->create();
    }
}
