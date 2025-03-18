<?php

namespace Database\Seeders;

use App\Models\Tipolicencia;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipolicenciaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipolicencia::create(['name'=>'Enfermedad comun']);
        Tipolicencia::create(['name'=>'Enfermedad largo tratamiento']);
        Tipolicencia::create(['name'=>'Atencion familiar']);
        Tipolicencia::create(['name'=>'Donacion de sangre']);
        Tipolicencia::create(['name'=>'Maternidad']);
        Tipolicencia::create(['name'=>'Nacimiento trabajo']);
        Tipolicencia::create(['name'=>'Salud embarazo']);
        Tipolicencia::create(['name'=>'Licencia pandemia']);
        Tipolicencia::create(['name'=>'Dto. 564/18 lic. extraordinaria ley 911-art 9']);
        
    }
}
