<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('tipolicencias')->insertOrIgnore([
            ['name' => 'Tareas livianas', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Reposo',          'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    public function down(): void
    {
        DB::table('tipolicencias')
            ->whereIn('name', ['Tareas livianas', 'Reposo'])
            ->delete();
    }
};
