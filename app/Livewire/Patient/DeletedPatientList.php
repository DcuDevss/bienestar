<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Paciente;

class DeletedPatientList extends Component
{
    // 👇 Habilita la paginación en el componente Livewire.
    use WithPagination;

    // 👇 Propiedad pública usada para el campo de búsqueda (input).
    public $search = '';

    /**
     * 🔁 Renderiza el componente cada vez que se actualiza algo (búsqueda, paginación, restauración, etc.)
     */
    public function render()
    {
        // 🧾 Obtiene únicamente los pacientes "soft-deleted" (eliminados lógicamente)
        // y filtra por nombre/apellido si el usuario escribe algo en $search.
        $pacientesEliminados = Paciente::onlyTrashed()
            ->where('apellido_nombre', 'like', "%{$this->search}%")
            ->orderByDesc('deleted_at') // Muestra primero los más recientemente eliminados
            ->paginate(10, ['*'], 'deletedPage'); // Paginación (10 por página)

        // 👇 Envía los resultados a la vista Livewire correspondiente.
        return view('livewire.patient.deleted-patient-list', [
            'pacientesEliminados' => $pacientesEliminados,
        ])->layout('layouts.app');
    }

    /**
     * ♻️ Restaura un paciente eliminado (SoftDelete → Restore)
     * @param int $id → ID del paciente eliminado
     */
    public function restore($id)
    {
        // Busca el paciente entre los eliminados
        $paciente = Paciente::onlyTrashed()->findOrFail($id);

        // Lo restaura (reactiva el registro)
        $paciente->restore();

        // Mensaje temporal de éxito (se muestra una sola vez)
        session()->flash('success', '✅ Paciente restaurado correctamente.');
    }

    /**
     * ❌ Elimina un paciente permanentemente de la base de datos
     * (elimina incluso el registro "soft deleted")
     * @param int $id → ID del paciente
     */
    public function forceDelete($id)
    {
        // Busca entre los eliminados
        $paciente = Paciente::onlyTrashed()->findOrFail($id);

        // Elimina definitivamente el registro
        $paciente->forceDelete();

        // Mensaje temporal de éxito
        session()->flash('success', '🗑️ Paciente eliminado permanentemente.');
    }
}
