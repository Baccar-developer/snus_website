<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class paymentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'payed_amount'=> fake()->randomFloat(32,100),
            'currency' => fake()->currencyCode(),
            'payment_status' => fake()->randomElement(['Complete' , 'InComplete' , 'Processing']),
            'transaction_id'=>fake()->unique()->password(5 ,18),
            'gateway_response'=>fake()->realText()
        ]; 
    }
}
