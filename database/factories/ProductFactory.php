<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'external_id' => $this->faker->unique()->numerify('####'),
            'title' => $this->faker->words(3, true),
            'price' => $this->faker->randomFloat(2, 10, 500),
            'description' => $this->faker->paragraph,
            'category' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'rating_rate' => $this->faker->randomFloat(1, 0, 5),
            'rating_count' => $this->faker->numberBetween(0, 1000),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
