<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Package>
 */
class PackageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'description' => fake()->text(),
            'min_price' => fake()->randomFloat(10, 0, 50),
            'max_price' => fake()->randomFloat(51, 0, 100),
            'return_percentage' => fake()->randomFloat(2, 0, 0.5),
            'active' => fake()->boolean(),
        ];
    }
}
