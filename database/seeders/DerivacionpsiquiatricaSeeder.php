<?php

namespace Database\Seeders;

use App\Models\DerivacionPsiquiatrica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DerivacionPsiquiatricaSeeder extends Seeder
{
    /**
     * Run the database seeeds.
     */
    public function run(): void
    {
        DerivacionPsiquiatrica::create(['name'=>'si']);
        DerivacionPsiquiatrica::create(['name'=>'no']);
        DerivacionPsiquiatrica::create(['name'=>'otros']);
    }
}
