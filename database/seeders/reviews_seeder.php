<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\products;
use App\Models\User;
use App\Models\reviews;

class reviews_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $r =1;

        foreach (products::pluck("product_id") as $p){
            foreach (User::pluck("id") as $c){
                if(rand(1,$r) ==$r){
                    $rate = rand(0,5);
                    reviews::factory(1)->create(["product_id"=>$p ,"customer_id" =>$c ,"rate"=>$rate]);
                }
                    
            }
            $reviews =  reviews::where("product_id" ,$p);
            $ratings = $reviews->count();
            $rate = $reviews->sum("rate");
            products::where("product_id" ,$p)->update(["ratings" =>$ratings ,"product_rate"=>$rate/$ratings]);
            
        }
    }
}
