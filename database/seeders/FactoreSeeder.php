<?php

namespace Database\Seeders;

use App\Models\Factore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FactoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Factore::create(['name'=>'Rh+']);
        Factore::create(['name'=>'Rh-']);
        Factore::create(['name'=>'A+']);
        Factore::create(['name'=>'A-']);
        Factore::create(['name'=>'B+']);
        Factore::create(['name'=>'B-']);
        Factore::create(['name'=>'AB+']);
        Factore::create(['name'=>'AB-']);
        Factore::create(['name'=>'O+']);
        Factore::create(['name'=>'0-']);
    }
}
