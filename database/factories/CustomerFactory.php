<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'customer_name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'tel_num' => '0'.rand(111111111,999999999),
            'address' => fake()->address(),
            'is_active' => fake()->numberBetween(0,1),
        ];
    }
}
