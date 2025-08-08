<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\product_seeder;
use Database\Seeders\admin_seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([product_seeder::class ,
            admin_seeder::class,
            users_seeder::class,
            charts_seeder::class,
            orders_seeder::class,
            chart_elements_seeder::class,
            payments_seeder::class,
            reviews_seeder::class,
        ]);
    }
}
