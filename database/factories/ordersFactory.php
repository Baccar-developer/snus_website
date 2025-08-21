<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\charts;
use App\Models\chart_elements;
use App\Models\products;
use \DateTime;

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
        $chart_id = fake()->unique()->randomElement(charts::pluck("chart_id"));
        $date = new DateTime();
        date_modify($date, "-".rand(0,2)."months");
        date_modify($date, "-".rand(1,20)."days");
        
        return [
                "chart_id"=> $chart_id,
                "location"=> fake()->address(),
                "order_status" =>fake()->randomElement(['delivered' ,'canceled' ,'unfulfilled']),
            "delivered_at"=> fake()->dateTimeThisYear()->format("Y-m-d h:i:s"),
                "price_per_DT"=>fake()->randomFloat(1,35,200),
                "payed"=> fake()->boolean(),
            "created_at"=> $date->format("Y-m-d h:i:s")
        ];
    }
}
