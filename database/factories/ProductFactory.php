<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'price' => fake()->randomFloat(2, 1, 1000),
            'stock_on_hand' => fake()->numberBetween(0, 100),
            'max_per_order' => fake()->boolean() ? fake()->numberBetween(1, 10) : null,
            'image_url' => fake()->imageUrl(),
        ];
    }
}
