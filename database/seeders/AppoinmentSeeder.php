<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AppoinmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         // User::flushEventListeners();//esto evita que se envien correos electronicos
         $this->call(RoleSeeder::class);
         //$this->call(PermissionSeeder::class);
         $this->call(UserSeeder::class);
         $this->call(JerarquiaSeeder::class);
         $this->call(FactoreSeeder::class);
         $this->call(EspecialidadeSeeder::class);
         $this->call(HoraSeeder::class);
         $this->call(SocialSeeder::class);
         $this->call(DiadetrabajoSeeder::class);
         $this->call(DisaseSeeder::class);
        // $this->call(EnfermedadeSeeder::class);
         $this->call(TipolicenciaSeeder::class);
        // $this->call(OficinaSeeder::class);
    }
}
