<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => \App\Models\Author::factory(),
            'title' => fake()->sentence(4),
            'description' => fake()->optional()->paragraph(),
            'publish_date' => fake()->optional()->date(),
        ];
    }
}
