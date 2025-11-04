<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('controlenfermeros', function (Blueprint $table) {
            // Nuevos campos
            $table->decimal('peso', 5, 2)->nullable()->after('id');       // Ej: 70.50
            $table->decimal('altura', 4, 2)->nullable()->after('peso');   // Ej: 1.75
            $table->string('talla')->nullable()->after('altura');         // Ej: M, L, XL
        });
    }

    public function down(): void
    {
        Schema::table('controlenfermeros', function (Blueprint $table) {
            $table->dropColumn(['peso', 'altura', 'talla']);
        });
    }
};
