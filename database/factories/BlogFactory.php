<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "title" => $this->faker->sentence(),
            "slug" =>  str::slug($this->faker->unique()->sentence()),
            "image" =>'blog/images/blog.webp',
            "images" => [
                            "blog/images/blog.webp",
                            "blog/images/physics.jpg",
                            "blog/images/prog.jpeg",
                        ],
            "content" => $this->faker->realText()
        ];
    }
}
