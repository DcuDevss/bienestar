<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Laravel\Prompts\table;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pacientes', function (Blueprint $table) {
            $table->id();
            // $table->string('escalafon')->nullable();
            $table->string('jerarquia')->nullable();
            $table->string('apellido_nombre')->nullable();
            $table->integer('legajo')->nullable();
            $table->integer('dni')->nullable();
            $table->string('estado')->nullable();
            $table->string('destino_actual')->nullable();
            $table->string('ciudad')->nullable();
            $table->integer('chapa')->nullable();
            $table->integer('NroCredencial')->nullable();
            $table->string('sexo')->nullable();
            $table->integer('cuil1')->nullable();
            $table->integer('dni_bis')->nullable();
            $table->integer('cuil2')->nullable();
            $table->string('TelefonoCelular')->nullable();
            $table->string('TelefonoFijo')->nullable();
            $table->string('domicilio')->nullable();
            $table->string('CiudadDomicilio')->nullable();
            $table->string('FecIngreso')->nullable();
            $table->string('fecNacimiento')->nullable();
            $table->string('FechaNombramiento')->nullable();
            $table->string('email')->nullable();
            $table->string('EmailOfic')->nullable();
            $table->integer('edad')->nullable();
            $table->integer('antiguedad')->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->float('peso')->nullable();
            $table->float('altura')->nullable();
            $table->unsignedBigInteger('estado_id')->nullable();
            $table->foreign('estado_id')->references('id')->on('estados')->onDelete('cascade');
            $table->unsignedBigInteger('factore_id')->nullable();
            $table->foreign('factore_id')->references('id')->on('factores')->onDelete('cascade');
            $table->unsignedBigInteger('jerarquia_id')->nullable();
            $table->foreign('jerarquia_id')->references('id')->on('jerarquias')->onDelete('cascade');
            $table->string('comisaria_servicio')->nullable();
            $table->timestamp('fecha_atencion')->nullable();
            $table->text('enfermedad')->nullable();
            $table->string('remedios')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pacientes');
    }
};
