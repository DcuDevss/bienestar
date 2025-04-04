<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jerarquia;

class JerarquiaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jerarquia::create(['name'=>'Comisario General']);
        Jerarquia::create(['name'=>'Comisario Mayor']);
        Jerarquia::create(['name'=>'Comisario Inspector']);
        Jerarquia::create(['name'=>'Comisario']);
        Jerarquia::create(['name'=>'Subcomisario']);
        Jerarquia::create(['name'=>'Principal']);
        Jerarquia::create(['name'=>'Inspector']);
        Jerarquia::create(['name'=>'Subinspector']);
        Jerarquia::create(['name'=>'Ayudante']);
        Jerarquia::create(['name'=>'Suboficial Mayor']);
        Jerarquia::create(['name'=>'Suboficial Auxiliar']);
        Jerarquia::create(['name'=>'Suboficial Escribiente']);
        Jerarquia::create(['name'=>'Sargento Primero']);
        Jerarquia::create(['name'=>'Sargento']);
        Jerarquia::create(['name'=>'Cabo Primero']);
        Jerarquia::create(['name'=>'Cabo']);
        Jerarquia::create(['name'=>'Agente']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Primera']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Segunada']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Tercera']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Cuarta']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Quinta']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Sexta']);
        Jerarquia::create(['name'=>'Auxiliar Superior de Septima']);
        Jerarquia::create(['name'=>'Auxiliar de Primera']);
        Jerarquia::create(['name'=>'Auxiliar de Segunada']);
        Jerarquia::create(['name'=>'Auxiliar de Tercera']);
        Jerarquia::create(['name'=>'Auxiliar de Cuarta']);
        Jerarquia::create(['name'=>'Auxiliar de Quinta']);
        Jerarquia::create(['name'=>'Auxiliar de Sexta']);
        Jerarquia::create(['name'=>'Auxiliar de Septima']);
        Jerarquia::create(['name'=>'Cadete']);
        Jerarquia::create(['name'=>'Aspirante a Agente']);
        Jerarquia::create(['name'=>'Postulante a Cadete']);
        Jerarquia::create(['name'=>'Postulante a Agente']);

    }
}
