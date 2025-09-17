<?php

namespace Database\Seeders;

use App\Models\IndicacionTerapeutica;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class IndicacionTerapeuticaSeeder extends Seeder
{
    /**
     * Run the database seeeds...
     */
    public function run(): void
    {
        IndicacionTerapeutica::create(['name'=>'diario']);
        IndicacionTerapeutica::create(['name'=>'semanal']);
        IndicacionTerapeutica::create(['name'=>'quincenal']);
        IndicacionTerapeutica::create(['name'=>'mes']);
        IndicacionTerapeutica::create(['name'=>'bimestral']);
        IndicacionTerapeutica::create(['name'=>'semestral']);
        IndicacionTerapeutica::create(['name'=>'anual']);
        IndicacionTerapeutica::create(['name'=>'otros']);

    }
}
