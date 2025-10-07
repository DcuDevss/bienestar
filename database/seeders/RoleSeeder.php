<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
//use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role1 = Role::create(['name' => 'super-admin']);
        $role2 = Role::create(['name' => 'admin-jefe']);
        $role3 = Role::create(['name' => 'administrativo']);
        $role4 = Role::create(['name' => 'doctor']);
        $role5 = Role::create(['name' => 'psicologa']);
        $role6 = Role::create(['name' => 'nutricionista']);
        $role7 = Role::create(['name' => 'enfermero']);
        $role8 = Role::create(['name' => 'profesorgym']);
        $role9 = Role::create(['name' => 'user_policia']);
        $role10 = Role::create(['name' => 'user_civil']);


        Permission::create(['name' => 'users.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'users.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=> 'users.update'])->syncRoles([$role1,$role2]);
       // Permission::create(['name'=> 'users.show'])->syncRoles([$role1,$role2]);

        Permission::create(['name' => 'roles.index'])->syncRoles([$role1,$role2]);
        Permission::create(['name' => 'roles.edit'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=> 'roles.create'])->syncRoles([$role1,$role2]);
        Permission::create(['name'=> 'roles.show'])->syncRoles([$role1,$role2]);


        Permission::create(['name' => 'oficinas.index'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'diadetrabajos.index'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'curriculum.index'])->syncRoles([$role1, $role2, $role4]);

        Permission::create(['name' => 'interviews.index'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6, $role7, $role8]);
        Permission::create(['name' => 'disases.index'])->syncRoles([$role1, $role2, $role4, $role7]);
        Permission::create(['name' => 'multiform.index'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role7, $role8]);
        Permission::create(['name' => 'patient-certificados.show'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6, $role7]);
        Permission::create(['name' => 'patient-enfermedades.show'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'patient-certificado.edit'])->syncRoles([$role1, $role2, $role4]);
        Permission::create(['name' => 'paciente.ver-historial'])->syncRoles([$role1, $role2, $role3, $role4, $role5, $role6, $role7]);

        Permission::create(['name' => 'psicologo.index'])->syncRoles([$role1, $role2, $role5]);

        Permission::create(['name' => 'enfermero.enfermero-historial'])->syncRoles([$role1, $role2, $role4,$role7]);
      
    }
}
