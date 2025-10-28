<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Crear roles (idempotente) con guard 'web'
        $R = [];
        foreach ([
            'super-admin',
            'admin-jefe',
            'administrativo',
            'doctor',
            'psicologa',
            'nutricionista',
            'enfermero',
            'profesorgym',
            'user_policia',
            'user_civil',
        ] as $name) {
            $R[$name] = Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
        }

        // Sets de permisos por rol (por NOMBRE)
        $adminJefe = [
            'users.index','users.edit','users.update',
            'roles.index','roles.edit','roles.create','roles.show',
            'oficinas.index','diadetrabajos.index','curriculum.index',
            'interviews.index','disases.index','multiform.index',
            'patient-certificados.show','patient-enfermedades.show','patient-certificado.edit',
            'paciente.ver-historial','psicologo.index','enfermero.enfermero-historial',
        ];

        $administrativo = [
            'oficinas.index','diadetrabajos.index','curriculum.index',
            'interviews.index','disases.index','multiform.index',
            'patient-certificados.show','patient-enfermedades.show',
            'paciente.ver-historial',
        ];

        $doctor = [
            'interviews.index',
            'patient-certificados.show','patient-enfermedades.show','patient-certificado.edit',
            'paciente.ver-historial',
        ];

        $psico     = ['psicologo.index','interviews.index','paciente.ver-historial'];
        $nutri     = ['interviews.index','paciente.ver-historial'];
        $enfermero = ['enfermero.enfermero-historial','paciente.ver-historial', 'interviews.index'];
        $profeGym  = ['interviews.index','paciente.ver-historial'];

        // Asignaciones (colecciones por nombre, se agrego cambios)
        $R['super-admin']->syncPermissions(Permission::where('guard_name', 'web')->get());
        $R['admin-jefe']->syncPermissions(Permission::whereIn('name', $adminJefe)->get());
        $R['administrativo']->syncPermissions(Permission::whereIn('name', $administrativo)->get());
        $R['doctor']->syncPermissions(Permission::whereIn('name', $doctor)->get());
        $R['psicologa']->syncPermissions(Permission::whereIn('name', $psico)->get());
        $R['nutricionista']->syncPermissions(Permission::whereIn('name', $nutri)->get());
        $R['enfermero']->syncPermissions(Permission::whereIn('name', $enfermero)->get());
        $R['profesorgym']->syncPermissions(Permission::whereIn('name', $profeGym)->get());

        // Usuarios finales por ahora sin permisos vamos
        $R['user_policia']->syncPermissions([]);
        $R['user_civil']->syncPermissions([]);

        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
