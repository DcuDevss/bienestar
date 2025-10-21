<?php

namespace App\Livewire\Interview;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Auditoria;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class InterviewResetAll extends Component
{

    public function resetAll()
    {
        $anioEntrante = now()->addYear()->year; // 👈 año que viene
        $inicioAnio   = Carbon::create($anioEntrante, 1, 1)->startOfDay();
        $finAnio      = Carbon::create($anioEntrante, 12, 31)->endOfDay();

        $pacientes = Paciente::with('disases')->get();

        $pacientesProcesados = 0;
        $certificadosProcesados = 0;

        foreach ($pacientes as $paciente) {
            $actualizoPaciente = false;

            foreach ($paciente->disases as $cert) {
                $inicioLic = Carbon::parse($cert->pivot->fecha_inicio_licencia)->startOfDay();
                $finLic    = Carbon::parse($cert->pivot->fecha_finalizacion_licencia)->startOfDay();

                // 👉 Cortamoos las fechas para que solo cuenten en el año entrante
                $inicio = $inicioLic->greaterThan($inicioAnio) ? $inicioLic : $inicioAnio;
                $fin    = $finLic->lessThan($finAnio) ? $finLic : $finAnio;

                $diasEnAnio = $inicio->lte($fin) ? $inicio->diffInDays($fin) + 1 : 0;

                $paciente->disases()->updateExistingPivot($cert->id, [
                    'suma_salud' => $diasEnAnio,
                ]);

                $certificadosProcesados++;
                $actualizoPaciente = true;
            }

            if ($actualizoPaciente) {
                $pacientesProcesados++;
            }
        }

        $usuario = Auth::user();

        // 🔹 Guardar en la tabla de auditorías
        Auditoria::create([
            'user_id' => $usuario?->id,
            'accion'  => 'reset_licencias_global',
            'detalle' => "Pacientes: {$pacientesProcesados}, Certificados: {$certificadosProcesados}",
        ]);

          $this->dispatch(
            'swal',
            title: 'Exito',
            text:  'Licencias Reseteadas con Exito!.',
            icon:  'success'
        );

    }



    public function render()
    {
        return view('livewire.interview.interview-reset-all');
    }
}
