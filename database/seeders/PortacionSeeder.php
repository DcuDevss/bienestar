<?php

namespace Database\Seeders;

use App\Models\Portacion;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PortacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Portacion::create(['name'=>'Apto para portar arma']);
        Portacion::create(['name'=>'Reintegrar arma reglamentaria']);
        Portacion::create(['name'=>'No apto para portar arma']);
    }
}
