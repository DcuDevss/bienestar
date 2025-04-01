<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run(): void
    {
        Estado::create(['name' => 'Servicio Efectivo']);
        Estado::create(['name' => 'Pasiva']);
        Estado::create(['name' => 'Disponibilidad']);
        Estado::create(['name' => 'Tramite de Baja']);
        Estado::create(['name' => 'Retiro']);
    }
}
