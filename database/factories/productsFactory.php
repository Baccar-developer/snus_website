<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class productsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $full_qnt = fake()->biasedNumberBetween( 1, 10);
        $price = fake()->randomFloat(1,32,40);
        return [
            'product_desc'=> fake()->text(),
            'price_per_DT'=>$price,
            'full_qnt'=>$full_qnt,
            'ordered_qnt' =>fake()->biasedNumberBetween(0 ,$full_qnt),
            'sold_qnt'=>fake()->biasedNumberBetween( 1,8),
            'gains_per_DT'=> fake()->biasedNumberBetween( 1,8) *$price,
            'rate'=>fake()->randomFloat(3,0,5),
            'ratings'=>fake()->biasedNumberBetween( 2,10),
            "wished_qnt"=> fake()->biasedNumberBetween(0 ,20)
        ];
    }
}
