<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Product>
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
        $name = fake()->firstName . ' ' . fake()->lastName;
        return [
            'name' => $name,
            'description' => fake()->realText(),
            'country_id' => fake()->numberBetween(1, 240),
            'price' => fake()->numberBetween(100, 500),
            'slug' => Str::slug($name)
        ];
    }
}
