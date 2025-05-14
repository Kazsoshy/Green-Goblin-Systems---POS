<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {
        return [
            'name' => $this->faker->unique()->words(3, true),
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'stock_quantity' => $this->faker->numberBetween(0, 100),
            'barcode' => $this->faker->unique()->ean13,
            'brand' => $this->faker->company,
            'location' => 'A' . $this->faker->numberBetween(1, 10) . 
                          '-B' . $this->faker->numberBetween(1, 5),
            'is_active' => $this->faker->boolean(90), // 90% chance of being active
        ];
    }
}