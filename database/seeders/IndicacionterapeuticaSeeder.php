<?php

namespace Database\Seeders;

use App\Models\Indicacionterapeutica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicacionterapeuticaSeeder extends Seeder
{
    /**
     * Run the database seeds...
     */
    public function run(): void
    {
        Indicacionterapeutica::create(['name'=>'diario']);
        Indicacionterapeutica::create(['name'=>'semanal']);
        Indicacionterapeutica::create(['name'=>'quincenal']);
        Indicacionterapeutica::create(['name'=>'mes']);
        Indicacionterapeutica::create(['name'=>'bimestral']);
        Indicacionterapeutica::create(['name'=>'semestral']);
        Indicacionterapeutica::create(['name'=>'anual']);
        Indicacionterapeutica::create(['name'=>'otros']);

    }
}
