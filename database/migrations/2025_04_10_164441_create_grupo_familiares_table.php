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
        Schema::create('grupo_familiares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrevista_id')->constrained()->onDelete('cascade'); // Relaciona con la tabla entrevista
            $table->string('nombre')->nullable(); // Nombre del miembro
            $table->integer('edad')->nullable(); // Edad del miembro
            $table->string('ocupacion')->nullable(); // Ocupación del miembro
            $table->string('parentesco')->nullable(); // Parentesco del miembro (opcional)
            $table->text('antecedentes_psiquiatricos')->nullable(); // Antecedentes psiquiátricos (opcional)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupo_familiares');
    }
};
