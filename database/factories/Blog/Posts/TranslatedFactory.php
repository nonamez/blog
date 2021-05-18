<?php

namespace Database\Factories\Blog\Posts;

use App\Models;
use Illuminate\Database\Eloquent\Factories\Factory;

class TranslatedFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Models\Blog\Posts\Translated::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = ['published', 'draft', 'hidden'];

        return [
            'status' => $status[array_rand($status)],
            
            'date' => now(),
            'markdown' => FALSE,
            'slug' => $this->faker->slug,
            'title' => $this->faker->words(3, TRUE),
            'content' => $this->faker->text,
            'meta_description' => $this->faker->text,
            'meta_keywords' => $this->faker->words(5, TRUE),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function(Models\Blog\Posts\Translated $post) {
            $tag = Models\Blog\Tags\Tag::inRandomOrder()->first();

            dd($tag);

            if ($tag) {
                $post->tags()->attach($tag);
            }
        });
    }
}
