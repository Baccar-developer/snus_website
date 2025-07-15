<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\admins;

use Illuminate\Support\Facades\Hash;

class admins_seeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        admins::create(['name'=>"ousama" , 'password'=>Hash::make('root')]);
    }
}
