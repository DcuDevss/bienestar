<?php

namespace Database\Seeders;

use App\Models\TipoEntrevista;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoEntrevistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        TipoEntrevista::create(['name' => 'Anual']);
        TipoEntrevista::create(['name' => 'Ascenso']);
        TipoEntrevista::create(['name' =>'Postulante']);
        TipoEntrevista::create(['name' =>'Reingreso']);
        TipoEntrevista::create(['name' =>'Espontánea']);
        TipoEntrevista::create(['name' => 'Reintegro Arma Reglamentaria']);
        TipoEntrevista::create(['name' =>'Cambio Situación de Revista']);
        TipoEntrevista::create(['name' =>'Tratamiento']);
        TipoEntrevista::create(['name' =>'Seguimiento']);
        TipoEntrevista::create(['name' =>'Intervención Sumario']);
        TipoEntrevista::create(['name' =>'Junta Médica']);

    }

}
