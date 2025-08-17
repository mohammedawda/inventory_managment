<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InventoryItem>
 */
class InventoryItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name'  => substr(fake()->sentence(2), 0, 20),
            'sku'   => fake()->randomLetter() . '_' . rand(1, 200000),
            'price' => fake()->randomFloat(4, 1, 99999999),
        ];
    }
}
