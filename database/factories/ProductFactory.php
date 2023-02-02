<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'description' => fake()->paragraphs(3, true),
            'price' => fake()->numberBetween(5000, 50000),
        ];
    }

    public function slug()
    {
        return $this->state(fn ($attributes) => [
            'slug' => str($attributes['name'])->slug()
        ]);
    }
}
