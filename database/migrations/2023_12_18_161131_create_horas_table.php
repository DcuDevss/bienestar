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
        Schema::create('horas', function (Blueprint $table) {
            $table->id();
            $table->time('time_hour')->nullable();//este es un campo de hora esete campo se va atransfroram en 12, 24 horas en csu valor enteros y nos va a decir el turno
            $table->string('str_hour_12')->nullable();//este es el formato de horas en 12
            $table->string('str_hour_24')->nullable();//este es el formato de horas en 24
            $table->integer('int_hour')->nullable();// esete nos indica que valor de horas es ejemplo las 12 las 24 etc...
            $table->string('turn')->nullable();//esete nos indica para saber si estamos en la manana , tarde , noche ose indica que valor de es
            $table->string('interval')->nullable();//este campo intervalo es para menejar la media hora anaterior y la actual
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horas');
    }
};
