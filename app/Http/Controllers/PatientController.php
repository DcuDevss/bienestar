<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Muestra la lista de pacientes que han sido eliminados (soft-deleted).
     *
     * La vista esperada es: resources/views/patient/deleted-patient-list.blade.php
     *
     * @return \Illuminate\View\View
     */
    public function eliminados()
    {
        // Obtiene SOLO los pacientes que tienen el campo deleted_at lleno.
        $pacientesEliminados = Paciente::onlyTrashed()
            ->orderByDesc('deleted_at')
            ->paginate(10);

        // Retorna la vista dedicada a la papelera.
        return view('patient.deleted-patient-list', [
            'pacientesEliminados' => $pacientesEliminados,
        ]);
    }

    /**
     * Restaura un paciente eliminado.
     *
     * @param int $pacienteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($pacienteId)
    {
        // Busca solo entre los eliminados y restaura
        $paciente = Paciente::onlyTrashed()->findOrFail($pacienteId);
        $paciente->restore();

        return redirect()->route('pacientes.eliminados')->with('success', 'Paciente restaurado exitosamente.');
    }

    /**
     * Elimina permanentemente un paciente.
     *
     * @param int $pacienteId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($pacienteId)
    {
        // Busca solo entre los eliminados y elimina permanentemente
        $paciente = Paciente::onlyTrashed()->findOrFail($pacienteId);
        $paciente->forceDelete();

        return redirect()->route('pacientes.eliminados')->with('success', 'Paciente eliminado permanentemente.');
    }
}
