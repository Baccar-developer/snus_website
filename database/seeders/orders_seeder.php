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
        orders::factory(20)->create();
    }
}
