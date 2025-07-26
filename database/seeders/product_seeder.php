<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\products;
use Database\Factories\productsFactory;

class product_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prodct_names=["killa" , "velo" ,"pablo"];
        foreach ($prodct_names as $name){
            $product  = products::factory(1)->create(["product_name"=>$name , "product_image"=>$name.'.jpeg']);
        }
    }
}
