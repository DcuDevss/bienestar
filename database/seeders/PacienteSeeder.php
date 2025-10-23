<?php

namespace Database\Seeders;

use App\Models\Paciente;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class PacienteSeeder extends Seeder
{
    public function run(): void
    {
        $csvPath = 'database/data/pacientes.csv';
        
        if (!File::exists($csvPath)) {
            $this->command->error("El archivo $csvPath no existe!");
            return;
        }

        $this->command->info('Leyendo archivo CSV...');
        $lines = file($csvPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (empty($lines)) {
            $this->command->error("El archivo CSV está vacío!");
            return;
        }

        // Obtener encabezados
        $headers = str_getcsv(array_shift($lines));
        $this->command->info('Encabezados encontrados: ' . implode(', ', $headers));

        // DIAGNÓSTICO: Mostrar posición de las columnas importantes
        $this->command->info("Posición de estado_id: " . array_search('estado_id', $headers));
        $this->command->info("Posición de jerarquia_id: " . array_search('jerarquia_id', $headers));
        $this->command->info("Posición de factore_id: " . array_search('factore_id', $headers));

        $this->command->info('Procesando ' . count($lines) . ' registros...');

        $bar = $this->command->getOutput()->createProgressBar(count($lines));
        $bar->start();

        $pacientes = [];
        $now = now();
        $errores = 0;

        foreach ($lines as $lineNumber => $line) {
            $row = str_getcsv($line);

            if (count($row) !== count($headers)) {
                $this->command->warn("Línea " . ($lineNumber + 2) . " omitida: Número de columnas incorrecto (" . count($row) . " vs " . count($headers) . ")");
                $errores++;
                $bar->advance();
                continue;
            }

            try {
                $data = array_combine($headers, $row);

                // DIAGNÓSTICO: Mostrar los valores de las primeras filas
                if ($lineNumber < 3) {
                    $this->command->info("Fila " . ($lineNumber + 2) . " - estado_id: " . ($data['estado_id'] ?? 'NO ENCONTRADO'));
                    $this->command->info("Fila " . ($lineNumber + 2) . " - jerarquia_id: " . ($data['jerarquia_id'] ?? 'NO ENCONTRADO'));
                    $this->command->info("Fila " . ($lineNumber + 2) . " - factore_id: " . ($data['factore_id'] ?? 'NO ENCONTRADO'));
                }

                $pacientes[] = [
                    'jerarquia' => $this->cleanString($data['jerarquia'] ?? null),
                    'jerarquia_id' => $this->parseInt($data['jerarquia_id'] ?? null),
                    'estado' => $this->cleanString($data['estado'] ?? null),
                    'estado_id' => $this->parseInt($data['estado_id'] ?? null),
                    'factore_id' => $this->parseInt($data['factore_id'] ?? null),
                    'apellido_nombre' => $this->cleanString($data['apellido_nombre'] ?? null),
                    'legajo' => $this->parseInt($data['legajo'] ?? null),
                    'dni' => $this->parseInt($data['dni'] ?? null),
                    'destino_actual' => $this->cleanString($data['destino_actual'] ?? null),
                    'ciudad' => $this->cleanString($data['ciudad'] ?? null),
                    'ciudad_id' => $this->parseInt($data['ciudad_id'] ?? null),
                    'chapa' => $this->parseInt($data['chapa'] ?? null),
                    'NroCredencial' => $this->parseInt($data['NroCredencial'] ?? null),
                    'sexo' => $this->cleanString($data['sexo'] ?? null),
                    'cuil1' => $this->parseInt($data['cuil1'] ?? null),
                    'dni_bis' => $this->parseInt($data['dni_bis'] ?? null),
                    'cuil2' => $this->parseInt($data['cuil2'] ?? null),
                    'TelefonoCelular' => $this->cleanString($data['TelefonoCelular'] ?? null),
                    'TelefonoFijo' => $this->cleanString($data['TelefonoFijo'] ?? null),
                    'domicilio' => $this->cleanString($data['domicilio'] ?? null),
                    'CiudadDomicilio' => $this->cleanString($data['CiudadDomicilio'] ?? null),
                    'FecIngreso' => $this->cleanString($data['FecIngreso'] ?? null),
                    'fecNacimiento' => $this->cleanString($data['fecNacimiento'] ?? null),
                    'FechaNombramiento' => $this->cleanString($data['FechaNombramiento'] ?? null),
                    'email' => $this->cleanString($data['email'] ?? null),
                    'EmailOfic' => $this->cleanString($data['EmailOfic'] ?? null),
                    'edad' => $this->parseInt($data['edad'] ?? null),
                    'antiguedad' => $this->parseInt($data['antiguedad'] ?? null),
                    'fecha_nacimiento' => $this->parseDate($data['fecha_nacimiento'] ?? null),
                    'peso' => $this->parseFloat($data['peso'] ?? null),
                    'altura' => $this->parseFloat($data['altura'] ?? null),
                    'comisaria_servicio' => $this->cleanString($data['comisaria_servicio'] ?? null),
                    'fecha_atencion' => $this->parseDateTime($data['fecha_atencion'] ?? null),
                    'enfermedad' => $this->cleanString($data['enfermedad'] ?? null),
                    'remedios' => $this->cleanString($data['remedios'] ?? null),
                    'cuil' => $this->parseInt($data['cuil'] ?? null),
                    'user_id' => $this->parseInt($data['user_id'] ?? null),
                    'created_at' => $this->parseDateTime($data['created_at'] ?? null) ?: $now,
                    'updated_at' => $this->parseDateTime($data['updated_at'] ?? null) ?: $now,
                ];
            } catch (\Exception $e) {
                $this->command->warn("Error procesando línea " . ($lineNumber + 2) . ": " . $e->getMessage());
                $errores++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();

        if ($errores > 0) {
            $this->command->warn("Se omitieron {$errores} registros debido a errores.");
        }

        if (empty($pacientes)) {
            $this->command->error("No se pudo procesar ningún registro!");
            return;
        }

        $this->command->info('Insertando ' . count($pacientes) . ' pacientes...');

        // Inserción masiva en lotes
        $chunks = array_chunk($pacientes, 100);
        $insertados = 0;

        foreach ($chunks as $chunkIndex => $chunk) {
            try {
                Paciente::insert($chunk);
                $insertados += count($chunk);
                $this->command->info("Lote {$chunkIndex} insertado: " . count($chunk) . " registros");
            } catch (\Exception $e) {
                $this->command->error("Error insertando lote {$chunkIndex}: " . $e->getMessage());
                // Mostrar más detalles del error
                $this->command->error("Detalles: " . $e->getMessage());
            }
        }

        $this->command->info('✅ ' . $insertados . ' pacientes insertados exitosamente!');
    }

    /**
     * Limpiar strings
     */
    private function cleanString($value)
    {
        if (empty($value) || $value === 'NULL' || $value === 'null') {
            return null;
        }
        return trim($value);
    }

    /**
     * Convertir a entero
     */
    private function parseInt($value)
    {
        if (empty($value) || $value === 'NULL' || $value === 'null') {
            return null;
        }
        $value = preg_replace('/[^0-9-]/', '', $value);
        return $value !== '' ? (int) $value : null;
    }

    /**
     * Convertir a float
     */
    private function parseFloat($value)
    {
        if (empty($value) || $value === 'NULL' || $value === 'null') {
            return null;
        }
        $value = str_replace(',', '.', $value);
        $value = preg_replace('/[^0-9.-]/', '', $value);
        return $value !== '' ? (float) $value : null;
    }

    /**
     * Formatear fecha
     */
    private function parseDate($value)
    {
        if (empty($value) || $value === 'NULL' || $value === 'null') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Formatear fecha y hora
     */
    private function parseDateTime($value)
    {
        if (empty($value) || $value === 'NULL' || $value === 'null') {
            return null;
        }

        try {
            return \Carbon\Carbon::parse($value)->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }
}