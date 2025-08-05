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
        Schema::create('tratamientos', function (Blueprint $table) {
            $table->id();
           //$table->string('profesional_actual')->nullable();
            $table->string('consumo_farmacos')->nullable();
           // $table->string('procedencia')->nullable();
            $table->text('antecedente_familiar')->nullable();
            $table->timestamp('fecha_atencion')->nullable();
            $table->string('profesional_enterior')->nullable();
           // $table->datetime('fecha_anterior')->nullable();
            $table->text('motivo_consulta_anterior')->nullable();
            //$table->text('motivo_consulta_actual')->nullable();
            $table->unsignedBigInteger('tipolicencia_id');
            $table->foreign('tipolicencia_id')->references('id')->on('tipolicencias')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('indicacionterapeutica_id');
            $table->foreign('indicacionterapeutica_id')->references('id')->on('indicacionterapeuticas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('derivacionpsiquiatrica_id');
            $table->foreign('derivacionpsiquiatrica_id')->references('id')->on('derivacionpsiquiatricas')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('procedencia_id');
            $table->foreign('procedencia_id')->references('id')->on('procedencias')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('enfermedade_id');
            $table->foreign('enfermedade_id')->references('id')->on('enfermedades')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientos');
    }
};
