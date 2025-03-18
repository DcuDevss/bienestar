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



        /* Permission::create(['name'=> 'oficinas.index','description'=>'solo ve el doctor,super-admin,admin-jefe.'])->syncRoles([$role1,$role2,$role4,$role7]);
       Permission::create(['name'=> 'diadetrabajos.index','description'=>'solo ve el doctor el super-admin, admin-jefe.'])->syncRoles([$role1,$role2,$role4]);
       Permission::create(['name'=> 'curriculum.index','description'=>'solo ve el doctor y super-admin, admin-jefe.'])->syncRoles([$role1,$role2,$role4]);

       Permission::create(['name'=> 'interviews.index','lo ven todos los roles'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7,$role8]);
       Permission::create(['name'=> 'disases.index','description'=>'solo ven super-admin, doctor, enfermero'])->syncRoles([$role1,$role2,$role4,$role7]);
       Permission::create(['name'=> 'multiform.index','description'=>'solo ven algunos '])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role7,$role8]);
       Permission::create(['name'=> 'patient-certificados.show','description'=>'solo ven algunos'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7]);
       Permission::create(['name'=> 'patient-enfermedades.show','description'=>'solo ven algunos'])->syncRoles([$role1,$role2,$role4]);
       Permission::create(['name'=> 'paciente.ver-historial','description'=>'solo ven algunos'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7]);
      // Permission::create(['name'=> 'indexComisaria1','description'=>'tabla del inventario/solo ven tecnicos-info'])->syncRoles([$role1,$role2]);
      //Permission::create(['name'=> 'ver-notificaciones','description'=>'tabla notificaciones de trabajo/solo ven tecnicos y admin'])->syncRoles([$role1,$role2,$role3]);
      // Permission::create(['name'=> 'crear-notificacion','description'=>'crea notificaciones/solo ven tecnicos y admin'])->syncRoles([$role1,$role2]);
      // Permission::create(['name'=> 'chatlist','description'=>'muestra lista de chat activos'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7,$role8,$role9]);
      // Permission::create(['name'=> 'userpolicia','description'=>'muestra los usuarios habilitados para el chat'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7,$role8,$role9]);
          */



        /*  Route::resource('/roles',RoleController::class)->names('roles');

Route::resource('/users',UserController::class)->names('users');


Route::resource('/especialidades',EspecialidadeController::class)->names('especialidades');


Route::get('get', function () {
    return view('doctor.index');
})->name('doctor.index');

Route::get('/oficinas', OficinaController::class)->name('oficinas.index');
Route::get('/diadetrabajos', DiadetrabajoController::class)->name('diadetrabajos.index');
Route::get('/curriculum', [CurriculumController::class, 'index'])->name('curriculum.index');
Route::get('/interviews/{paciente}', [InterviewController::class, 'index'])->name('interviews.index');
//Route::get('/disases', Multiform::class)->name('multiform.index');
Route::get('/disases', DisaseController::class)->name('disases.index');
Route::get('/multiform', MultiformController::class)->name('multiform.index');
Route::get('patient/show/{paciente}', PatientHistorialCertificado::class)->name('patient-certificados.show');
Route::get('patient/edit/{paciente}', PatientHistorialEnfermedades::class)->name('patient-enfermedades.show');
Route::get('paciente/show/{paciente}', PacienteHistorialGeneral::class)->name('paciente-general.show');
Route::get('paciente/edit/{paciente}', PacienteEditCertificado::class)->name('paciente-certificado.edit');
Route::get('/paciente/ver-historial/{paciente}', VerHistorial::class)->name('paciente.ver-historial');
Route::get('/interviews/detail/{interview}', [InterviewController::class, 'detail'])->name('interviews.detail');
*/


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
        // Permission::create(['name'=> 'indexComisaria1','description'=>'tabla del inventario/solo ven tecnicos-info'])->syncRoles([$role1,$role2]);
        //Permission::create(['name'=> 'ver-notificaciones','description'=>'tabla notificaciones de trabajo/solo ven tecnicos y admin'])->syncRoles([$role1,$role2,$role3]);
        // Permission::create(['name'=> 'crear-notificacion','description'=>'crea notificaciones/solo ven tecnicos y admin'])->syncRoles([$role1,$role2]);
        // Permission::create(['name'=> 'chatlist','description'=>'muestra lista de chat activos'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7,$role8,$role9]);
        // Permission::create(['name'=> 'userpolicia','description'=>'muestra los usuarios habilitados para el chat'])->syncRoles([$role1,$role2,$role3,$role4,$role5,$role6,$role7,$role8,$role9]);

    }
}
