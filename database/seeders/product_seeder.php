<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\products;

class product_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        products::create([
            "name"=>"Killa",
            "description"=>"this is a snus with flavor of .........",
            "price_per_DT"=>35,
            "full_quantity"=>20,
            "ordered_quantity"=>2,
            "gains_per_DT"=>100,
            "ratings"=>0, "rate"=>0,
            "sold_quantity"=>10,
            "image"=>"Killa.png"
        ]);
    }
}
