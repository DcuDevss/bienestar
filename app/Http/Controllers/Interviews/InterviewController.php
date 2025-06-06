<?php

namespace App\Http\Controllers\Interviews;

use App\Http\Controllers\Controller;
use App\Models\Disase;
use App\Models\Interview;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class InterviewController extends Controller
{

public function index(Paciente $paciente)
{
    $tiposLicencia = \App\Models\Tipolicencia::all();

    // Suma individual por cada tipo de licencia
    $sumasPorTipo = [];

    foreach ($tiposLicencia as $tipo) {
        $sumasPorTipo[$tipo->name] = $paciente->disases()
            ->where('disase_paciente.tipolicencia_id', $tipo->id)
            ->sum('disase_paciente.suma_salud');
    }

    // Última enfermedad
    $ultimaFechaEnfermedad = $paciente->disases()->latest('disase_paciente.fecha_finalizacion_licencia')->first();

    return view('interviews.index', compact(
        'paciente',
        'ultimaFechaEnfermedad',
        'sumasPorTipo'
    ));
}




    public function detail(Interview $interview){

        $patient = User::find($interview->patient_id);
        $paciente= Paciente::find($interview->paciente_id);
        $doctor = User::find($interview->doctor_id);

        return view('interviews.detail',compact('interview','doctor','patient','paciente'));
    }

    public function resetSums(Paciente $paciente)
{
    // Reiniciar las sumas a cero
    $paciente->disases()->update(['suma_salud' => 0]);
    $paciente->disases()->where('tipolicencia_id', 'Atencion familiar')->update(['suma_salud' => 0]);

    // Redirigir de nuevo a la página de detalle del paciente
    return redirect()->route('interviews.index', ['interview' => $paciente->id])
                    ->with('success', 'Sumas reiniciadas correctamente.');
}


}
