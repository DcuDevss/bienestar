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
        Schema::create('disase_paciente', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_presentacion_certificado')->nullable();
            $table->timestamp('fecha_inicio_licencia')->nullable();
            $table->timestamp('fecha_finalizacion_licencia')->nullable();
            $table->integer('horas_salud')->nullable();
            $table->integer('suma_salud')->nullable();
            $table->integer('suma_auxiliar')->nullable();
            $table->text('detalle_certificado')->nullable();
            $table->string('imagen_frente')->nullable();
            $table->string('imagen_dorso')->nullable();
            $table->boolean('estado_certificado')->default(true)->nullable();
            $table->unsignedBigInteger('disase_id');
            $table->unsignedBigInteger('paciente_id');
            $table->foreign('disase_id')->references('id')->on('disases')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade')->onUpdate('cascade');
            $table->string('tipodelicencia')->nullable();
            $table->unsignedBigInteger('tipolicencia_id')->nullable();
            $table->foreign('tipolicencia_id')->references('id')->on('tipolicencias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disase_paciente');
    }
};
