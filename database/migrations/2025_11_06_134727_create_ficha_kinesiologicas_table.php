<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fichas_kinesiologicas', function (Blueprint $table) {
            $table->id();
            



            // === I. DATOS ADMINISTRATIVOS / ANAMNESIS ===
            $table->string('diagnostico')->nullable();
            $table->text('motivo_consulta')->nullable();


            $table->text('posturas_dolorosas')->nullable();

            $table->boolean('realiza_actividad_fisica')->nullable();
            $table->string('tipo_actividad')->nullable();

            // Antecedentes
            $table->text('antecedentes_enfermedades')->nullable();
            $table->text('antecedentes_familiares')->nullable();
            $table->text('cirugias')->nullable();
            $table->text('traumatismos_accidentes')->nullable();
            $table->text('tratamientos_previos')->nullable();

            // Datos gineco-obstétricos
            $table->boolean('menarca')->nullable(); // true = sí, false = no
            $table->boolean('menopausia')->nullable(); // true = sí, false = no
            $table->integer('partos')->nullable();

            // Estado general
            $table->enum('estado_salud_general', ['Bueno', 'Medio', 'Malo'])->nullable();
            $table->boolean('alteracion_peso')->nullable(); // true = sí, false = no
            $table->text('medicacion_actual')->nullable();
            $table->text('observaciones_generales_anamnesis')->nullable();

            // --- II. EXAMEN EOM ---
            // EXAMEN VISCERAL
            $table->text('visceral_palpacion')->nullable();
            $table->text('visceral_dermalgias')->nullable();
            $table->text('visceral_triggers')->nullable();
            $table->text('visceral_fijaciones')->nullable();
            // EXAMEN CRANEAL
            $table->string('craneal_forma')->nullable();
            $table->text('craneal_triggers')->nullable();
            $table->text('craneal_fijaciones')->nullable();
            $table->text('craneal_musculos')->nullable();
            // EXAMEN CARDIOVASCULAR
            $table->string('tension_arterial')->nullable();
            $table->string('pulsos')->nullable();
            $table->string('auscultacion')->nullable();
            $table->string('ecg')->nullable();
            $table->string('ecodoppler')->nullable();

            //relaciones
            $table->unsignedBigInteger('paciente_id')->nullable();  // Campo que vincula la entrevista con el paciente
            $table->foreign('paciente_id')->references('id')->on('pacientes')->onDelete('cascade');

            // user_id → corregido (solo se declara una vez)
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('doctors')->onDelete('cascade');


            $table->unsignedBigInteger('obra_social_id')->nullable();
            $table->foreign('obra_social_id')->references('id')->on('obra_socials')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fichas_kinesiologicas');
    }
};