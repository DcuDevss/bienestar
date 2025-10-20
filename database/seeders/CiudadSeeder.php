<?php

namespace Database\Seeders;

use App\Models\Ciudade;
use Illuminate\Database\Seeder;

class CiudadSeeder extends Seeder
{
    public function run()
    {
        Ciudade::create([
            'nombre' => 'Ushuaia',
            'cp' => '9410',
        ]);

        Ciudade::create([
            'nombre' => 'Tolhuin',
            'cp' => '9412',
        ]);

        Ciudade::create([
            'nombre' => 'Rio Grande',
            'cp' => 'V9420',
        ]);
    }
}
