<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\customers>
 */
class customersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "customer_name"=>fake()->firstName(),
            "email"=>fake()->email(),
            "tel"=>fake()->phoneNumber(),
            "password"=>fake()->password()
        ];
    }
}
