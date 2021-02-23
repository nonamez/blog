<?php

namespace Database\Factories\Blog\Tags;

use App\Models\Blog\Tags\Tag;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $words = $this->faker->words(3, TRUE);

        return [
            'slug' => Str::slug($words),
            'name' => $words,
        ];
    }
}
