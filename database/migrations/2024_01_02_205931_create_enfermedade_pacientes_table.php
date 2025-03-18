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


        Schema::create('enfermedade_pacientes', function (Blueprint $table) {
            $table->id();
            $table->timestamp('fecha_atencion2')->nullable();
            $table->text('detalle_enfermedad2')->nullable();
            $table->string('horas_reposo2')->nullable();
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
        Schema::dropIfExists('enfermedade_pacientes');
    }
};
