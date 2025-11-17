<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('registro_sesiones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained()->onDelete('cascade');

            $table->integer('sesion_nro')->nullable();
            $table->date('fecha_sesion')->nullable();
            $table->text('tratamiento_fisiokinetico')->nullable();
            $table->text('evolucion_sesion')->nullable();
            $table->boolean('firma_paciente_digital')->nullable()->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registro_sesiones');
    }
};