<?php

namespace App\Livewire\Interview;

use App\Models\Paciente;
use Carbon\Carbon;
use Livewire\Component;

class InterviewGeneral extends Component
{
    public Paciente $paciente;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    public function resetGeneral()
    {
        $inicioAnio = now()->startOfYear();
        $finAnio    = now()->endOfYear();

        $certificados = $this->paciente->disases()->get();

        foreach ($certificados as $cert) {
            $tipoId = $cert->pivot->tipolicencia_id;

            $idAtencionFamiliar = 4;

            $inicioLic = Carbon::parse($cert->pivot->fecha_inicio_licencia)->startOfDay();
            $finLic    = Carbon::parse($cert->pivot->fecha_finalizacion_licencia)->startOfDay();

            // Calcular intersección con el año actual
            $inicio = $inicioLic->greaterThan($inicioAnio) ? $inicioLic : $inicioAnio;
            $fin    = $finLic->lessThan($finAnio) ? $finLic : $finAnio;

            $diasEnAnio = 0;
            if ($inicio->lte($fin)) {
                $diasEnAnio = $inicio->diffInDays($fin) + 1;
            }

            // 🔹 Diferenciar atendibles y salud
            if ($tipoId == $idAtencionFamiliar) {
                // Atendibles
                $this->paciente->disases()->updateExistingPivot($cert->id, [
                    'suma_salud' => $diasEnAnio,
                ]);
            } else {
                // Salud
                $this->paciente->disases()->updateExistingPivot($cert->id, [
                    'suma_salud' => $diasEnAnio,
                ]);
            }
        }

        $this->paciente->load('disases');

        session()->flash('success', 'Se reiniciaron las sumas de salud y atendibles del paciente actual.');
    }


    public function render()
    {
        return view('livewire.interview.interview-general');
    }
}
