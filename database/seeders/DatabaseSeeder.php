<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Estado;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
         // User::flushEventListeners();//esto evita que se envien correos electronicos
         $this->call(RoleSeeder::class);
         //$this->call(PermissionSeeder::class);TipoEntrevistaSeeder
         $this->call(UserSeeder::class);
         $this->call(JerarquiaSeeder::class);
         $this->call(FactoreSeeder::class);
         $this->call(EspecialidadeSeeder::class);
         $this->call(HoraSeeder::class);
         $this->call(SocialSeeder::class);
         $this->call(DiadetrabajoSeeder::class);
         $this->call(DisaseSeeder::class);
         $this->call(ProcedenciaSeeder::class);
         $this->call(TipolicenciaSeeder::class);
         $this->call(DerivacionpsiquiatricaSeeder::class);
         $this->call(IndicacionterapeuticaSeeder::class);
         $this->call(EstadoSeeder::class);
         $this->call(TipoEntrevistaSeeder::class);
     
    }
}
