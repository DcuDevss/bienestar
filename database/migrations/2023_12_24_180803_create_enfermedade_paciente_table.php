<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('enfermedade_paciente', function (Blueprint $table) {
            $table->id();
            //$table->date('presentacion_certificado')->nullable();
            $table->timestamp('fecha_atencion_enfermedad')->nullable();
            $table->timestamp('fecha_finalizacion_enfermedad')->nullable();
            $table->string('tipodelicencia')->nullable();
            $table->text('detalle_diagnostico')->nullable();
            $table->integer('horas_reposo')->nullable();
            $table->string('imgen_enfermedad')->nullable();
            $table->string('pdf_enfermedad')->nullable();
            $table->string('medicacion')->nullable();
            $table->string('dosis')->nullable();
            $table->text('detalle_medicacion')->nullable();
            $table->text('motivo_consulta')->nullable();
            $table->string('nro_osef')->nullable();
            $table->string('art')->nullable();
            $table->boolean('estado_enfermedad')->default('0')->nullable();
            $table->string('derivacion_psiquiatrica')->nullable();
            $table->unsignedBigInteger('paciente_id');
            $table->unsignedBigInteger('enfermedade_id');
            $table->foreign('enfermedade_id')->references('id')->on('enfermedades')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfermedade_paciente');
    }
};
