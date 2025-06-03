<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePdfPsiquiatrasTable extends Migration
{
    public function up()
    {
        Schema::create('pdf_psiquiatras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('paciente_id')->constrained('pacientes')->onDelete('cascade');
            $table->string('filename');
            $table->string('filepath');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('pdf_psiquiatras');
    }
}

