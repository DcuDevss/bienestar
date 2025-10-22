<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaludMentalesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Ruta al archivo CSV
        $csvFile = database_path('data/salud_mentales.csv');

        // Verificar si el archivo existe
        if (!file_exists($csvFile)) {
            return;
        }

        // Leer el archivo CSV
        $data = array_map('str_getcsv', file($csvFile));

        // Saltar la primera fila si contiene encabezados
        $header = array_shift($data);

        // Iterar sobre las filas del CSV
        foreach ($data as $row) {
            // Mapear las columnas del CSV a los campos de la tabla
            // Ajustado según el ejemplo del error: codigo, name, slug
            $saludMental = [
                'codigo' => $row[0] ?? null,
                'name' => $row[1] ?? null,
                'slug' => isset($row[2]) ? $row[2] : Str::slug($row[1] ?? ''), // Generar slug si no está en el CSV
            ];

            // Insertar en la base de datos
            DB::table('salud_mentales')->insert($saludMental);
        }
    }
}