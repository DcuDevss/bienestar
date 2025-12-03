<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\Interviews\InterviewController;
use Illuminate\Http\Request;
use App\Models\Doctor;
use App\Models\Especialidade;
use App\Models\User;
use App\Http\Controllers\Admin\EspecialidadeController;
//use App\Http\Controllers\Admin\RoleController;
//use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;

use App\Http\Controllers\Doctor\CurriculumController;
use App\Http\Controllers\NuevoUsuarioController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\Psicologo\PsicologoController;
use App\Http\Controllers\PdfController;
//use App\Http\Controllers\Interviews\InterviewController;
use App\Http\Livewire\Paciente\PdfViewer as PacientePdfViewer;
use App\Livewire\Paciente\PdfViewer;
use App\Livewire\Doctor\DiaDeTrabajoController;
use App\Livewire\Doctor\DisaseController;
use App\Livewire\Doctor\EnfermedadeController;
use App\Livewire\Doctor\MultiformController;
use App\Livewire\Doctor\EditPatientController;
use App\Livewire\Doctor\EntrevistaFormController;
use App\Livewire\Doctor\EditEntrevista;
use App\Livewire\Doctor\PdfPsiquiatraController;
use App\Livewire\Doctor\EntrevistaIndex;
use App\Livewire\Doctor\OficinaController;
use App\Livewire\Enfermero\EnfermeroController;
use App\Livewire\Enfermero\EnfermeroHistorial;
use App\Livewire\Multiform;
use App\Livewire\Paciente\PacienteEditCertificado;
use App\Livewire\Paciente\PacienteHistorialGeneral;
use App\Livewire\Paciente\VerHistorial;
use App\Livewire\Patient\PatientControlHistorial;
use App\Livewire\Patient\PatientHistorial;
use App\Livewire\Patient\PatientHistorialCertificado;
use App\Livewire\Patient\PatientHistorialEnfermedades;
use App\Livewire\Patient\PatientTratamiento;
use App\Livewire\Patient\PatientEntrevistas;
use App\Livewire\Auditorias\AuditoriaList;
use App\Livewire\Auditorias\AuditoriaGeneral;
use App\Models\Paciente;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Stats\LicenciasStats;
use App\Livewire\Stats\PostulantesStats;
use App\Http\Controllers\PrintReportsController;
use App\Livewire\Kinesiologia\FichaKinesiologicaEdit;
use App\Livewire\Kinesiologia\FichaKinesiologicaIndex;
use App\Livewire\Patient\DeletedPatientList;
use App\Livewire\Kinesiologia\KinesiologiaForm;
use App\Livewire\Kinesiologia\ListaPlanillas;
use App\Livewire\Kinesiologia\PdfsKinesiologia;
use App\Livewire\Kinesiologia\SesionKinesiologica;
use App\Http\Controllers\Kinesiologia\FichaPdfController;



/*
|--------------------------------------------------------------------------
| Web Routes ffff
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//Route::get('/', [\Laraavel\Fortify\Http\Controllers\AuthenticatedSessionController::class, 'create'])->middleware('guest');



Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

/********nuevo********/

Route::middleware([
    'auth',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        $user = Auth::user(); // Obténgo al usuario autenticado
        // Lógica para redirigir según el rol
        if ($user->hasRole('super-admin')) {
            return view('dashboard');
            //return redirect()->intended(route('panel-administrador'));
        } elseif ($user->hasRole('doctor')) {
            //return redirect()->intended(route('dashboard'));
            return view('dashboard');
        } elseif ($user->hasRole('enfermero')) {
            // return redirect()->intended(route('dashboard'));
            return view('dashboard');
        } elseif ($user->hasRole('psicologa')) {
            // return view('panel-administrador');
            //return redirect()->intended(route('psicologo.index'));
            return view('dashboard');
        } elseif ($user->hasRole('admin-jefe')) {
            return view('dashboard');
        } else {
            return view('dashboard');
        }
    })->name('dashboard');
});
/***finailza*** */

Route::view('/administrador', 'administrador')->name('panel-administrador');
//Route::get('/psicologo', [PsicologoController::class, 'index'])->middleware('can:psicologo.index')->name('psicologo.index');

Route::get('get', function () {
    return view('admin.index');
})
    ->name('admin.index')->middleware((['can:admin.index']));


//rutas de roles todas index, show, create, edit cambios de rodri
//Route::resource('/roles',RoleController::class)->names('roles');

//Route::resource('/users',UserController::class)->names('users');


Route::resource('/especialidades', EspecialidadeController::class)->names('especialidades');


Route::get('get', function () {
    return view('doctor.index');
})->name('doctor.index');

Route::get('/oficinas', OficinaController::class)->middleware('can:oficinas.index')->name('oficinas.index');
Route::get('/diadetrabajos', DiaDeTrabajoController::class)->middleware('can:diadetrabajos.index')->name('diadetrabajos.index');
Route::get('/curriculum', [CurriculumController::class, 'index'])->middleware('can:curriculum.index')->name('curriculum.index');
Route::get('/interviews/{paciente}', [InterviewController::class, 'index'])->middleware('can:interviews.index')->name('interviews.index');
Route::post('/interviews/{paciente}', [InterviewController::class, 'resetSums'])->name('reset-sums'); // web.php
Route::get('/pdfs/{filename}', [PdfController::class, 'show'])->name('pdf.show');
Route::get('/auditorias', AuditoriaList::class)->name('auditorias.index');
Route::get('/auditorias/general', AuditoriaGeneral::class)->name('auditorias.auditoria-general');



//Route::get('/disases', Multiform::class)->name('multiform.index');
Route::get('/disases', DisaseController::class)->middleware('can:disases.index')->name('disases.index');
Route::get('/multiform', MultiformController::class)->middleware('can:multiform.index')->name('multiform.index');
Route::get('paciente/{customerId}/edit', EditPatientController::class)->name('patient.edit');
Route::get('paciente/{paciente_id}/entrevista/create', EntrevistaFormController::class)->name('entrevista.create');
Route::get('/entrevistas/{paciente_id}', EntrevistaIndex::class)->name('entrevistas.index');
Route::get('/entrevistas/editar/{entrevista_id}', EditEntrevista::class)->name('entrevistas.edit');
Route::get('/entervistas/pdf-psiquiatra/{paciente}', PdfPsiquiatraController::class)->name('entrevistas.pdf-psiquiatra');


Route::get('patient/show/{paciente}', PatientHistorialCertificado::class)->middleware('can:patient-certificados.show')->name('patient-certificados.show');
Route::get('patient/edit/{paciente}', PatientHistorialEnfermedades::class)->middleware('can:patient-enfermedades.show')->name('patient-enfermedades.show');
Route::get('paciente/show/{paciente}', PacienteHistorialGeneral::class)->middleware('can:paciente-general.show')->name('paciente-general.show');
Route::get('paciente/edit/{paciente}', PacienteEditCertificado::class)->middleware('can:paciente-certificado.edit')->name('paciente-certificado.edit');

Route::get('/patinet/patient-tratamiento/{paciente}', PatientTratamiento::class)->name('patient.patient-tratamiento');
Route::get('/patient/patient-historial/{paciente}/{tratamiento}', PatientHistorial::class)->name('patient.patient-historial');
Route::get('/patient/patient-entrevistas', PatientEntrevistas::class)->name('patient.patient.patient-entrevistas');
//Route::get('/patient/patient-control-historial/{paciente}/{enfermedade}', PatientControlHistorial::class)->name('patient.patient-control-historial');

Route::get('/patient/patient-control-historial/{paciente}/{enfermedade_paciente_id}', PatientControlHistorial::class)
    ->name('patient.patient-control-historial');


Route::get('/paciente/ver-historial/{paciente}', VerHistorial::class)->middleware('can:paciente.ver-historial')->name('paciente.ver-historial');
Route::get('/interviews/detail/{interview}', [InterviewController::class, 'detail'])->middleware('can:interviews.detail')->name('interviews.detail');

Route::get('/enfermero/enfermero-historial/{paciente}', EnfermeroHistorial::class)->middleware('can:enfermero.enfermero-historial')->name('enfermero.enfermero-historial');

Route::resource('users', UserController::class)->only('index', 'edit', 'update', 'destroy');
Route::resource('roles', RoleController::class)->names('admin-roles');
//Route::get('/reservar-turno', TurnoReservation::class);

//Nuevo usuario
Route::get('nuevo_usuario', [NuevoUsuarioController::class, 'create'])->name('new-user');
Route::post('nuevo_usuario', [NuevoUsuarioController::class, 'store'])->name('new-user.store');

//estadisticas
Route::get('/stats/licencias-stats', LicenciasStats::class)->name('stats.licencias-stats');
Route::get('/stats/postulantes-stats', PostulantesStats::class)->name('stats.postulantes-stats');

//impresiones en PDF
Route::get('/prints/postulantes', [PrintReportsController::class, 'postulantes'])
    ->name('prints.postulantes');
Route::get('/prints/licencias', [PrintReportsController::class, 'licencias'])
    ->name('prints.licencias');
// routes/web.php


/* // NUEVA RUTA para Pacientes Eliminados (Papelera)
Route::get('/pacientes/eliminados', [PatientController::class, 'eliminados'])->name('pacientes.eliminados'); */
Route::get('/pacientes/eliminados', DeletedPatientList::class)
    ->name('patient.deleted-patient-list');


// Formulario para crear ficha
Route::get('/pacientes/{paciente}/kinesiologia', KinesiologiaForm::class)
    ->name('kinesiologia.index');

// Lista de fichas de un paciente
Route::get('/fichas-kinesiologicas/{paciente}', FichaKinesiologicaIndex::class)
    ->name('kinesiologia.ficha-kinesiologica-index');

// Editar ficha específica
Route::get('/fichas-kinesiologicas/kinesiologia/{ficha}/edit', FichaKinesiologicaEdit::class)
    ->name('kinesiologia.ficha-kinesiologica-edit');

// Lista general de planillas
Route::get('/kinesiologia/planillas', ListaPlanillas::class)
    ->name('kinesiologia.lista-planillas');

// PDFs de Kinesiología
Route::get('/paciente/{paciente}/kinesiologia/pdfs', PdfsKinesiologia::class)
    ->name('kinesiologia.pdfs-kinesiologia');

//registro de sesiones
Route::get('/pacientes/{paciente}/sesiones', SesionKinesiologica::class)
    ->name('kinesiologia.sesion-kinesiologica');

//PDF para ver de kinesiologia

Route::get('/kinesiologia/ficha-pdf/{fichaId}', [FichaPdfController::class, 'view'])
    ->name('kinesiologia.pdf-ficha');
