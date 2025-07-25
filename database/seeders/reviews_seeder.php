<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\products;
use App\Models\customers;
use App\Models\reviews;

class reviews_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $r =6;
        foreach (products::pluck("product_id") as $p){
            foreach (customers::pluck("customer_id") as $c){
                if(rand(1,$r) ==$r){
                    reviews::factory(1)->create(["product_id"=>$p ,"customer_id" =>$c]);
                }
            }
        }
    }
}
