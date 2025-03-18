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
        Schema::create('diadetrabajos', function (Blueprint $table) {
            $table->id();
            $table->boolean('active')->default(false);//aqui verificamos si un canpo es inactivo o esta activo
            $table->integer('day')->default(0)->nullable();//aqui coloco el numero de dias.es un campo que vas desde el 0 al 6
            $table->integer('morning_start')->default(0)->nullable();//aqui colocamos el inicio de la consulta en la manana. utilzamos un campo enetro para mapera las horas en ces de usar time
            $table->integer('morning_end')->default(0)->nullable();//aqui va el fin de la consulta en la manana aqui utilzamos un campo enetro para mapera las horas en ces de usar time
            $table->integer('afternoon_start')->default(0)->nullable();//aqui va el incio de la manana
            $table->integer('afternoon_end')->default(0)->nullable();//aqui vva la finalizacion de la noche.
            $table->integer('evening_start')->default(0)->nullable();
            $table->integer('evening_end')->default(0)->nullable();
            $table->integer('morning_office')->default(0)->nullable();
            $table->integer('afternoon_office')->default(0)->nullable();
            $table->integer('evening_office')->default(0)->nullable();
            $table->float('morning_price')->default(0)->nullable();//precio de la consulta en la manana
            $table->float('afternoon_price')->default(0)->nullable();//precio de la consulta en la tarde
            $table->float('evening_price')->default(0)->nullable();//precio de la constulta en l anoche
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('users')
            ->onDelete('cascade')
            ->onUpdate('cascade')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diadetrabajos');
    }
};
