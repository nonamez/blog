<?php

namespace Database\Factories\Blog\Posts;

use App\Models;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Models\Blog\Posts\Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => Models\Users\User::inRandomOrder()->first()->id
        ];
    }
}
