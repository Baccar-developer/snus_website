<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\orders;

class orders_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        orders::create([
            "quantity"=>2,
            "order_price"=>70,
            'governorate'=>'Sousse' ,
            'location'=>'virtual' ,
            'state'=>'unfulfilled' ,
            'delivered_at'=>null ,
            'product_name'=>'Killa' ,
            'tel'=>'11111111',
            'payed'=>false,
            
        ]);
        orders::create([
            "quantity"=>2,
            "order_price"=>70,
            'governorate'=>'Sousse' ,
            'location'=>'virtual' ,
            'state'=>'delivered' ,
            'delivered_at'=>'2025-07-01 01:44:18' ,
            'product_name'=>'Killa' ,
            'tel'=>'22222222',
            'payed'=>true,
            
        ]);
        
    }
}
