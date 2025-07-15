<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\product_seeder;
use Database\Seeders\orders_seeder;
use Database\Seeders\admins_seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        
        $this->call([product_seeder::class]);
        $this->call([orders_seeder::class]);
        $this->call([admins_seeder::class]);
    }
}
