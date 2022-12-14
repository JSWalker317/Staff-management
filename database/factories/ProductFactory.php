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
    public function definition()
    {
        // $productCoverPhotos = [null];
        // for ($i = 1; $i < 11; $i++) {
        //     $productCoverPhotos[] = 'product' . $i;
        // }
        $name = fake()->name();
        return [
            'product_id' => substr($name,0,1) . rand(100000000, 999999999),
            'product_name' => $name,
            // 'product_image' => fake()->randomElement($productCoverPhotos),
            'product_price' => $this->faker->randomFloat(2, 29, 79),
            'is_sales' => fake()->numberBetween(0,1),
            'description' => $this->faker->sentence($this->faker->biasedNumberBetween(4, 8)),
        ];
    }
}
