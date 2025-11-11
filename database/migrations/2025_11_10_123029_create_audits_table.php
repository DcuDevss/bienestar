<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // usuario que ejecuta
            $table->string('action');                     // ej: 'certificado.create', 'paciente.update'
            $table->morphs('auditable');                 // auditable_type (Modelo) + auditable_id
            $table->text('description')->nullable();     // texto libre
            $table->string('ip_address', 45)->nullable();
            $table->string('user_agent', 255)->nullable();
            $table->timestamps();                        // created_at = fecha/hora de la acción
        });
    }

    public function down(): void {
        Schema::dropIfExists('audits');
    }
};
