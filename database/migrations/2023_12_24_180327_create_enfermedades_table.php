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
        Schema::create('enfermedades', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->nullable();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
           // $table->timestamp('fecha_atencion')->nullable();
            //$table->timestamp('fecha_finalizacion')->nullable();
           // $table->string('horas_salud')->nullable();
           // $table->string('archivo')->nullable();
           // $table->string('tipodelicencia')->nullable();
           // $table->boolean('activo')->default(true)->nullable();
           // $table->text('symptoms')->nullable();
           // $table->unsignedBigInteger('tipolicencia_id')->nullable();
           // $table->foreign('tipolicencia_id')->references('id')->on('tipolicencias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enfermedades');
    }
};
