<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\chart_elements;
use App\Models\products;
use App\Models\charts;

class chart_elements_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $r = 6;
        $product_ids = products::pluck("product_id");
        $chart_ids = charts::pluck("chart_id");
        foreach ($product_ids as $id){
            foreach ($chart_ids as $id_ch){
                if (fake()->biasedNumberBetween(1,$r)==$r){
                    chart_elements::factory(1)->create(["product_id"=>$id , "chart_id"=>$id_ch]);
                }
            }
        }
        
    }
}
