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
        Schema::create('obra_socials', function (Blueprint $table) {
            $table->id();
            // Campo principal (Obligatorio)
            $table->string('name')->unique();
            $table->string('telefono_contacto')->nullable(); 
            $table->string('email_contacto')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('obra_socials');
    }
};
