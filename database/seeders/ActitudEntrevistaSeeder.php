<?php

namespace Database\Seeders;

use App\Models\ActitudEntrevista;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ActitudEntrevistaSeeder extends Seeder
{
    public function run(): void
{
    ActitudEntrevista::create(['name' => 'Excelente']);
    ActitudEntrevista::create(['name' => 'Muy Buena']);
    ActitudEntrevista::create(['name' => 'Buena']);
    ActitudEntrevista::create(['name' => 'Regular']);
    ActitudEntrevista::create(['name' => 'Mala']);
    ActitudEntrevista::create(['name' => 'Muy Mala']);
    }
}
