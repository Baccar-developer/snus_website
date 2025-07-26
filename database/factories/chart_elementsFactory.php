<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\charts;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\shippings>
 */
class chart_elementsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        
        return [
            "qnt"=> fake()->numberBetween(1 , 3)
        ];
    }
}
