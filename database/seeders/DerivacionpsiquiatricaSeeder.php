<?php

namespace Database\Seeders;

use App\Models\Derivacionpsiquiatrica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DerivacionpsiquiatricaSeeder extends Seeder
{
    /**
     * Run the database seeeds.
     */
    public function run(): void
    {
        Derivacionpsiquiatrica::create(['name'=>'si']);
        Derivacionpsiquiatrica::create(['name'=>'no']);
        Derivacionpsiquiatrica::create(['name'=>'otros']);
    }
}
