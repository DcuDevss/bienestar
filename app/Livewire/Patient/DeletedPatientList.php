<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Paciente;

class DeletedPatientList extends Component
{
    use WithPagination;

    // 👇 Livewire usa Tailwind por defecto
    protected $paginationTheme = 'tailwind';

    public $search = '';

    // ✅ Nueva propiedad para controlar la cantidad de resultados por página
    public $perPage = 8; // Valor predeterminado a 8 (como en la imagen)

    // 📢 Escucha eventos Livewire.emit()
    protected $listeners = [
        'restore' => 'restore',
        'forceDelete' => 'forceDelete',
    ];

    /**
     * 🔄 Reinicia la paginación al cambiar la búsqueda
     */
    public function updatingSearch()
    {
        $this->resetPage('deletedPage');
    }

    /**
     * ✅ Reinicia la paginación al cambiar la cantidad de resultados por página
     */
    public function updatingPerPage()
    {
        $this->resetPage('deletedPage');
    }

    /**
     * 🎯 Renderiza el componente con los pacientes eliminados
     */
    public function render()
    {
        // ✅ Usamos $this->perPage en la función paginate
        $pacientesEliminados = Paciente::onlyTrashed()
            ->where('apellido_nombre', 'like', "%{$this->search}%")
            ->orderByDesc('deleted_at')
            ->paginate($this->perPage, ['*'], 'deletedPage');

        return view('livewire.patient.deleted-patient-list', [
            'pacientesEliminados' => $pacientesEliminados,
        ])->layout('layouts.app');
    }

    /**
     * ♻️ Restaura un paciente eliminado
     */
    public function restore($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);
        $paciente->restore();

        $this->dispatch(
            'swal',
            title: '¡Restaurado!',
            text: 'Paciente restaurado correctamente.',
            icon: 'success'
        );

        $this->resetPage('deletedPage');
    }

    /**
     * ❌ Elimina un paciente permanentemente
     */
    public function forceDelete($id)
    {
        $paciente = Paciente::withTrashed()->findOrFail($id);
        $paciente->forceDelete();

        $this->dispatch(
            'swal',
            title: '¡Eliminado!',
            text: 'Paciente eliminado permanentemente de la base de datos.',
            icon: 'error'
        );

        $this->resetPage('deletedPage');
    }
}
