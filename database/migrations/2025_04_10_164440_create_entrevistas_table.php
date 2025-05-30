<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('entrevistas', function (Blueprint $table) {
        $table->id();
        $table->foreignId('tipo_entrevista_id')->nullable()->constrained()->onDelete('cascade');
        $table->boolean('posee_arma')->nullable();
        $table->boolean('posee_sanciones')->nullable();
        $table->string('motivo_sanciones')->nullable();
        $table->boolean('causas_judiciales')->nullable();
        $table->string('motivo_causas_judiciales')->nullable();
        $table->boolean('sosten_de_familia')->nullable();
        $table->boolean('sosten_economico')->nullable();
        $table->boolean('tiene_embargos')->nullable();
        $table->boolean('enfermedad_preexistente')->nullable();  // Permitir NULL
        $table->text('medicacion')->nullable();
        $table->boolean('realizo_tratamiento_psicologico')->nullable();
        $table->string('hace_cuanto_tratamiento_psicologico')->nullable();
        $table->text('signos_y_sintomas')->nullable();
        $table->date('fecha')->nullable();
        $table->string('profesional')->nullable();
        $table->string('duracion')->nullable();
        $table->string('motivo')->nullable();
        $table->text('medicacion_recetada')->nullable();
        $table->boolean('fuma')->nullable();
        $table->integer('cantidad_fuma')->nullable();
        $table->boolean('consume_alcohol')->nullable();
        $table->string('frecuencia_alcohol')->nullable();
        $table->boolean('consume_sustancias')->nullable();
        $table->string('tipo_sustancia')->nullable();
        $table->boolean('realiza_actividades')->nullable();
        $table->string('actividades')->nullable();
        $table->integer('horas_dormir')->nullable();
        $table->boolean('horas_suficientes')->nullable();
        $table->foreignId('actitud_entrevista_id')->nullable()->constrained()->onDelete('cascade');
        $table->text('notas_clinicas')->nullable();
        $table->text('tecnica_utilizada')->nullable();
        $table->foreignId('indicacionterapeutica_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('abordaje_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('portacion_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('enfermedad_id')->nullable()->constrained()->onDelete('cascade');
        $table->string('derivacion_psiquiatrica')->nullable();
        $table->text('evolucion_tratamiento')->nullable();
        $table->boolean('aptitud_reintegro')->nullable();
        $table->foreignId('estado_entrevista_id')->nullable()->constrained()->onDelete('cascade');
        $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
        $table->unsignedBigInteger('paciente_id')->nullable();  // Campo que vincula la entrevista con el paciente
        $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('entrevistas');
    }
};
