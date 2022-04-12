<?php

namespace Database\Factories\Invoices;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;

use Faker;

class ClientFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Models\Invoices\Client::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $this->faker->addProvider(new Faker\Provider\at_AT\Payment($this->faker));
        $this->faker->addProvider(new Faker\Provider\ar_SA\Person($this->faker));

        return [
            'user_id' => Models\Users\User::inRandomOrder()->first()->id,

            'name' => $this->faker->company,
            'address' => $this->faker->streetAddress,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'company_code' => $this->faker->randomNumber(7),
            'vat_code' => $this->faker->vat,
        ];
    }
}
