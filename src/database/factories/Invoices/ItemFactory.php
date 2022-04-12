<?php

namespace Database\Factories\Invoices;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Models\Invoices\Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'invoice_id' =>  Models\Invoices\Invoice::inRandomOrder()->first()->id,
            
            'description' => $this->faker->sentence(5),
            'quantity' => rand(1,10),
            'price' => rand(1,30),
        ];
    }
}
