<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\customers;

class customers_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        customers::factory(10)->create();
    }
}
