<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'slug' => $this->faker->slug(3),
            'content' => $this->faker->paragraphs(5, true),
            'image' => $this->faker->imageUrl(800, 600, 'Lesson'),
        ];
    }
}
