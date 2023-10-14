<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ActivityFactory extends Factory
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
            'image' => $this->faker->imageUrl(800, 600, 'activity'),
            'description' => $this->faker->paragraphs(2, true),
            'rules' => $this->faker->paragraphs(2, true),
            'duration' => $this->faker->randomNumber(2),
            'type_id' => 1,
        ];
    }
}
