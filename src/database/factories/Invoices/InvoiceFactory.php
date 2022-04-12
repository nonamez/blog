<?php

namespace Database\Factories\Invoices;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;

class InvoiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Models\Invoices\Invoice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'client_id'  => Models\Invoices\Client::inRandomOrder()->first()->id,
            
            'invoiced_at' => now(),
            'due_until'   => now()->addDays(10),
        ];
    }
}
