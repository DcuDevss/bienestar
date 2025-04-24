<?php

namespace Database\Seeders;

use App\Models\EstadoEntrevista;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoEntrevistaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    EstadoEntrevista::create(['name' => 'Apto']);
    EstadoEntrevista::create(['name' => 'No Apto']);
    EstadoEntrevista::create(['name' =>'Condicional']);

}

}

