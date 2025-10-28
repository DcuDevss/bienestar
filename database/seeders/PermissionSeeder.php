<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\PermissionRegistrar;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar cache de Spatie
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Definí todos los permisos que usa tu app
        $permissions = [
            // Gestión de usuarios/roles
            'admin.index',
            'users.index','users.create','users.store','users.edit','users.update','users.destroy','users.show',
            'roles.index','roles.create','roles.store','roles.edit','roles.update','roles.destroy','roles.show',

            // Secciones
            'oficinas.index','oficinas.create','oficinas.store','oficinas.edit','oficinas.update','oficinas.destroy','oficinas.show',
            'diadetrabajos.index',
            'curriculum.index',
            'interviews.index','interviews.detail',
            'disases.index',
            'multiform.index',

            // Pacientes / historias
            'patient-certificados.show',
            'patient-enfermedades.show',
            'patient-certificado.edit',
            'paciente.ver-historial',

            // Áreas específicas
            'psicologo.index',
            'enfermero.enfermero-historial',
        ];

        // Crear si no existen (idempotente)
        foreach ($permissions as $name) {
            Permission::findOrCreate($name, 'web');
        }

        // Refrescar cache
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
