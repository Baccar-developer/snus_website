<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\charts;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ordersFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
                "chart_id"=>  fake()->unique()->randomElement(charts::pluck("chart_id")),
                "location"=> fake()->address(),
                "order_status" =>fake()->randomElement(['delivered' ,'canceled' ,'unfulfilled']),
                "delivered_at"=>fake()->dateTimeBetween("-1 months" , "now")
        ];
    }
}
