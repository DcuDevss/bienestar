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
        Schema::create('controlenfermeros', function (Blueprint $table) {
            $table->id();
            $table->string('presion')->nullable();
            $table->string('glucosa')->nullable();
            $table->string('inyectable')->nullable();
            $table->timestamp('fecha_atencion')->nullable();
            $table->integer('dosis')->nullable();
            $table->integer('temperatura')->nullable();
            $table->text('detalles')->nullable();
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
        Schema::dropIfExists('controlenfermeros');
    }
};
