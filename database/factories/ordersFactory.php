<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\charts;
use App\Models\chart_elements;
use App\Models\products

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
        
        $chart_elements = chart_elements::where("chart_id" ,$chart_id)->leftJoin("products" , "products.product_id" , "chart_elements.product_id")->get("price_per_DT","qnt");
        $price = 0;
        foreach ($chart_elements as $c){
            $price+= $c->price_per_DT * $c->qnt;
        }
        return [
                "chart_id"=> $chart_id,
                "location"=> fake()->address(),
                "order_status" =>fake()->randomElement(['delivered' ,'canceled' ,'unfulfilled']),
                "delivered_at"=>fake()->dateTimeBetween("-1 months" , "now"),
                "price_per_DT"=>$price,
                "payed"=> fake()->boolean()
        ];
    }
}
