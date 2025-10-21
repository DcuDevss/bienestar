<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DerivacionPsiquiatrica;

class DerivacionPsiquiatricaSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['si', 'no', 'otros'] as $name) {
            DerivacionPsiquiatrica::firstOrCreate(['name' => $name]);
        }
    }
}
