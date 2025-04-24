<?php

namespace Database\Seeders;

use App\Models\Abordaje;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbordajeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{
    Abordaje::create(['name' => 'Individual']);
    Abordaje::create(['name' => 'Vincular']);
    Abordaje::create(['name' => 'Familiar']);
}

}
