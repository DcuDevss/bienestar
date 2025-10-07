<?php

namespace App\Livewire\Interview;

use App\Models\Paciente;
use Livewire\Component;
use Carbon\Carbon;

class InterviewReset extends Component
{
    public Paciente $paciente;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    /**
     * Resetea solo los certificados de salud (no Atención familiar) del año actual
     */
    public function resetSums()
    {
        $this->resetByType('salud');
        session()->flash('success', 'Sumas de salud reiniciadas correctamente para este año.');
    }

    /**
     * Resetea solo los certificados atendibles (Atención familiar) del año actual
     */
    public function resetSumsAtendibles()
    {
        $this->resetByType('atendible');
        session()->flash('success', 'Sumas de atendibles reiniciadas correctamente para este año.');
    }

    /**
     * Lógica de reseteo avanzado: descuenta solo los días del año actual
     */
    private function resetByType(string $tipo)
    {
        $inicioAnio = now()->startOfYear();
        $finAnio    = now()->endOfYear();

        $certificados = $this->paciente->disases()->get();

        // ⚠️ IMPORTANTE: id real de "Atención familiar"
        $idAtencionFamiliar = 4;

        foreach ($certificados as $cert) {
            $tipoId = $cert->pivot->tipolicencia_id;

            // Filtrar según tipo
            if ($tipo === 'atendible' && $tipoId != $idAtencionFamiliar) {
                continue;
            }
            if ($tipo === 'salud' && $tipoId == $idAtencionFamiliar) {
                continue;
            }

            $inicioLic = Carbon::parse($cert->pivot->fecha_inicio_licencia)->startOfDay();
            $finLic    = Carbon::parse($cert->pivot->fecha_finalizacion_licencia)->startOfDay();

            // Calcular solo los días que caen dentro del año actual
            $inicio = $inicioLic->greaterThan($inicioAnio) ? $inicioLic : $inicioAnio;
            $fin    = $finLic->lessThan($finAnio) ? $finLic : $finAnio;

            $diasEnAnio = $inicio->lte($fin) ? $inicio->diffInDays($fin) + 1 : 0;

            $this->paciente->disases()->updateExistingPivot($cert->id, [
                'suma_salud' => $diasEnAnio,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.interview.interview-reset');
    }
}
