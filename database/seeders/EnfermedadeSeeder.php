<?php

namespace Database\Seeders;

use App\Models\Enfermedade;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class EnfermedadeSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = 'database/data/enfermedades.json';

        if (!File::exists($jsonPath)) {
            $this->command->error("El archivo $jsonPath no existe!");
            return;
        }

        $jsonContent = File::get($jsonPath);
        $jsonContent = str_replace('"name": NaN', '"name": null', $jsonContent);

        $data = json_decode($jsonContent);

        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->command->error('Error decodificando JSON: ' . json_last_error_msg());
            return;
        }

        $this->command->info('Cargando ' . count($data) . ' enfermedades...');

        $bar = $this->command->getOutput()->createProgressBar(count($data));
        $bar->start();

        // Solo limpiar si hay datos existentes
        if (Enfermedade::count() > 0) {
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Enfermedade::truncate();
            \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        foreach ($data as $obj) {
            if (empty($obj->name) || $obj->name === null) {
                $bar->advance();
                continue;
            }

            Enfermedade::create([
                'codigo' => $obj->codigo ?? null,
                'name' => mb_strtolower($obj->name),
                'slug' => Str::slug($obj->name),
            ]);

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✅ ' . count($data) . ' enfermedades insertadas exitosamente!');
    }
}
