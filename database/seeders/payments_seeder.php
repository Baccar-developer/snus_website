<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\orders;
use App\Models\payments;

class payments_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $r =6;
        foreach(orders::pluck("order_id") as $id){
            if (rand(1 ,$r) < $r){
                payments::factory(1)->create(["order_id" =>$id]);
            }
        }
        
    }
}
