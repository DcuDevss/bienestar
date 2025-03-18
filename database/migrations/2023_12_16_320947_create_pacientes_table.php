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
            $table->string('escalafon')->nullable();
            $table->string('jerarquia')->nullable();
            $table->string('apellido_nombre')->nullable();
            $table->string('legajo')->nullable();
            $table->integer('dni')->nullable();
            $table->string('destino_actual')->nullable();
            $table->string('ciudad')->nullable();
            $table->string('cuil')->nullable();
            $table->string('direccion')->nullable();
            $table->string('email')->nullable();
            $table->string('telefono')->nullable();
            //$table->string('destino_anterior')->nullable();
            //$table->string('educacion')->nullable();
           // $table->string('genero')->nullable();
           // $table->string('estado_civil')->nullable();
           // $table->string('apellido_nombre_pareja')->nullable();
           // $table->string('genero')->nullable();
           //$table->string('vivienda')->nullable();
          // $table->string('sanciones')->nullable();
          //$table->string('anos_desempeno_actual')->nullable();
         // $table->string('destino_anterior')->nullable();
         //$table->string('causas_judiciales')->nullable();
          // $table->string('motivos_judiciales')->nullable();
          //  $table->string('sumarios_administrativos')->nullable();
           // $table->string('motivos_sumarios')->nullable()
            // $table->string('denuncias_exposiciones')->nullable();;
         //$table->string('convivientes')->nullable();
           // $table->string('hijos')->nullable();
            // $table->string('horario_laboral')->nullable();
             // $table->string('recargos')->nullable();
              // $table->string('adicional')->nullable();
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
