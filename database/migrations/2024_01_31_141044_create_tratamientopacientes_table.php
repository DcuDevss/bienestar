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
        Schema::create('tratamientopacientes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('disase_paciente_id');
            $table->unsignedBigInteger('paciente_id');
            $table->text('estado_tratamiento')->nullable();
            $table->timestamp('fecha_atencion')->nullable();
            $table->timestamp('fecha_finalizacion')->nullable();
            $table->string('medicacion')->nullable();
            $table->boolean('estado')->default('0')->nullable();
            

            // Foreign keys
            $table->foreign('disase_paciente_id')->references('id')->on('disase_paciente')->onDelete('cascade');
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tratamientopacientes');
    }
};
