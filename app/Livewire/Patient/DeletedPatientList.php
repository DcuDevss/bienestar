<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Paciente;

class DeletedPatientList extends Component
{
    use WithPagination;

    public $search = '';

    // 📢 Mapea los eventos de JavaScript (Livewire.emit) a los métodos de la clase
    protected $listeners = [
        'restore' => 'restore',
        'forceDelete' => 'forceDelete',
    ];

    /**
     * Reinicia la paginación cuando cambia la búsqueda.
     */
    public function updatingSearch()
    {
        $this->resetPage('deletedPage');
    }

    

    /**
     * Renderiza el componente y filtra los pacientes eliminados.
     */
    public function render()
    {
        $pacientesEliminados = Paciente::onlyTrashed()
            ->where('apellido_nombre', 'like', "%{$this->search}%")
            ->orderByDesc('deleted_at')
            ->paginate(10, ['*'], 'deletedPage');

        return view('livewire.patient.deleted-patient-list', [
            'pacientesEliminados' => $pacientesEliminados,
        ])->layout('layouts.app');
    }

    /**
     * ♻️ Restaura un paciente eliminado.
     */
    public function restore($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);

        $paciente->restore();

        // 🟢 NUEVO: Notificación directa (dispatch)
        $this->dispatch(
            'swal',
            title: '¡Restaurado!',
            text: '✅ Paciente restaurado correctamente. Ahora está activo en la lista principal.',
            icon: 'success'
        );

        $this->resetPage('deletedPage');
    }

    /**
     * ❌ Elimina un paciente permanentemente.
     */
    public function forceDelete($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);

        $paciente->forceDelete();

        // 🔴 NUEVO: Notificación directa (dispatch)
        $this->dispatch(
            'swal',
            title: '¡Eliminado!',
            text: '🗑️ Paciente eliminado permanentemente de la base de datos.',
            icon: 'error'
        );

        $this->resetPage('deletedPage');
    }
}
