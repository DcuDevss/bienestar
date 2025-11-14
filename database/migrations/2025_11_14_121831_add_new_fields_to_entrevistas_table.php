<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('entrevistas', function (Blueprint $table) {

            $table->string('posee_vivienda_propia')->nullable();
            $table->string('tiempo_en_ultimo_destino')->nullable();
            $table->string('destino_anterior')->nullable();

            $table->date('fecha_ultimo_ascenso')->nullable();

            $table->string('horario_laboral')->nullable();
            $table->string('hace_adicionales')->nullable();
            $table->string('anios_residencia_isla')->nullable();

            // 🔽 CAMBIADOS A TEXT COMO PEDISTE
            $table->text('posee_oficio_profesion')->nullable();
            $table->text('situacion_laboral')->nullable();
            $table->text('relacion_companieros_superiores')->nullable();
            $table->text('situacion_familiar')->nullable();
            $table->text('ultimos_6_meses')->nullable();
            $table->text('ultimos_dias_semanas')->nullable();
            $table->text('pesadillas_trabajo')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('entrevistas', function (Blueprint $table) {
            $table->dropColumn([
                'posee_vivienda_propia',
                'tiempo_en_ultimo_destino',
                'destino_anterior',
                'fecha_ultimo_ascenso',
                'horario_laboral',
                'hace_adicionales',
                'anios_residencia_isla',
                'posee_oficio_profesion',
                'situacion_laboral',
                'relacion_companieros_superiores',
                'situacion_familiar',
                'ultimos_6_meses',
                'ultimos_dias_semanas',
                'pesadillas_trabajo',
            ]);
        });
    }
};
