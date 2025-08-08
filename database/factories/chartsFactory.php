<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class chartsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $created_at = fake()->dateTimeBetween("-1 months" , "now");
        return [
            "customer_id"=>fake()->randomElement(User::pluck("id")),
            "created_at"=>$created_at,
            "updated_at"=> fake()->dateTimeBetween($created_at , "now")
        ];
    }
}
