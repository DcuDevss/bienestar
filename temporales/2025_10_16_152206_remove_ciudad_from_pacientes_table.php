<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/* MOVER A CARPETA TEMP porque al ejecutar el comando AsignarCiudadId el campo ciudad va a estar borrado por la migracion */

return new class extends Migration
{
    public function up()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->dropColumn('ciudad');
        });
    }

    public function down()
    {
        Schema::table('pacientes', function (Blueprint $table) {
            $table->string('ciudad')->nullable();
        });
    }
};
