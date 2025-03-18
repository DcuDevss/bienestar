<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //permisos de roles
        Permission::create(['name'=>'admin.index','privilege'=>'admin panel']);
        Permission::create(['name'=>'roles.index','privilege'=>'role list']);
        Permission::create(['name'=>'roles.create','privilege'=>'role create']);
        Permission::create(['name'=>'roles.store','privilege'=>'role create']);
        Permission::create(['name'=>'roles.edit','privilege'=>'role edit']);
        Permission::create(['name'=>'roles.update','privilege'=>'role edit']);
        Permission::create(['name'=>'roles.destroy','privilege'=>'role delete']);
        Permission::create(['name'=>'roles.show','privilege'=>'role view']);
       // Permission::create(['name'=>'roles.index','privilege'=>'role list']);
       // Permission::create(['name'=>'roles.index','privilege'=>'role list']);
        //Permission::create(['name'=>'roles.index','privilege'=>'role list']);
        //Permission::create(['name'=>'roles.index','privilege'=>'role list']);


        //permisos de usuarios de user

        //Permission::create(['name'=>'users.index','privilege'=>'users panel']);
        Permission::create(['name'=>'users.index','privilege'=>'users list']);
        Permission::create(['name'=>'users.create','privilege'=>'users create']);
        Permission::create(['name'=>'users.store','privilege'=>'users create']);
        Permission::create(['name'=>'users.edit','privilege'=>'users edit']);
        Permission::create(['name'=>'users.update','privilege'=>'users edit']);
        Permission::create(['name'=>'users.destroy','privilege'=>'users delete']);
        Permission::create(['name'=>'users.show','privilege'=>'users view']);


         //permiso de doctor admin
         //Permission::create(['name'=>'doctor.index','privilege'=>'doctor panel']);

         //Permisos de Oficina

         Permission::create(['name'=>'oficinas.index','privilege'=>'oficinas list']);
         Permission::create(['name'=>'oficinas.create','privilege'=>'oficinas create']);
         Permission::create(['name'=>'oficinas.store','privilege'=>'oficinas create']);
         Permission::create(['name'=>'oficinas.edit','privilege'=>'oficinas edit']);
         Permission::create(['name'=>'oficinas.update','privilege'=>'oficinas edit']);
         Permission::create(['name'=>'oficinas.destroy','privilege'=>'oficinas delete']);
         Permission::create(['name'=>'oficinas.show','privilege'=>'oficinaa view']);



        $permissionss=[1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22];

        $superAdmin=Role::findByName('super-admin');
        $admin=Role::findByName('admin');
        $superAdmin->givePermissionTo($permissionss);
        $admin->givePermissionTo($permissionss);
        //$superAdmin=Role::findByName('administrativo');
        //$superAdmin=Role::findByName('super-admin');
        //$superAdmin=Role::findByName('super-admin');

        //asignacion de permisos de doctor de
        $permissions = [16,17,18,19,20,21,22];
        $doctor = Role::findByName('doctor');
        $psicologa = Role::findByName('psicologa');
        $enfermero = Role::findByName('enfermero');
       // $admin->givePermissionTo($permissions);
        $doctor->givePermissionTo($permissions);
        $psicologa->givePermissionTo($permissions);
        $enfermero->givePermissionTo($permissions);


    }
}
