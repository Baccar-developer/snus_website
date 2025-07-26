<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\charts;

class charts_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        charts::factory(20)->create();
    }
}
