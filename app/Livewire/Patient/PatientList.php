<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use App\Models\Paciente;

class PatientList extends Component
{
    use WithPagination;

    #[Url(history: true)] public $search = '';
    #[Url(history: true)] public $admin  = '';
    #[Url(history: true)] public $sortBy = 'id';
    #[Url(history: true)] public $sortDir = 'ASC';
    #[Url] public $perPage = 8;

    /* ---------- Confirmación SweetAlert ---------- */
    public function confirmarEliminar(int $id, string $nombre = '')
    {
        $this->dispatch('confirm', [
            'title'       => '¿Eliminar paciente?',
            'text'        => $nombre !== '' ? "Se eliminará «{$nombre}». Esta acción no se puede deshacer." : 'Esta acción no se puede deshacer.',
            'icon'        => 'warning',
            'confirmText' => 'Sí, eliminar',
            'cancelText'  => 'Cancelar',
            'action'      => 'eliminar-paciente', // listener abajo
            'params'      => ['id' => $id],
        ]);
    }

    #[On('eliminar-paciente')]
    public function delete($payload)
    {
        // Soporta escalar o {id: ...}
        $id = is_array($payload) ? ($payload['id'] ?? null) : $payload;

        Log::debug('[PatientList] delete() recibido', ['payload' => $payload, 'id' => $id]);

        if (!$id) {
            Log::warning('[PatientList] eliminar-paciente SIN id', ['payload' => $payload]);
            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'No se recibió el ID del paciente.',
                'icon'  => 'error',
            ]);
            return;
        }

        try {
            $paciente = Paciente::findOrFail($id);
            $nombre   = $paciente->apellido_nombre;

            $paciente->delete(); // usa SoftDeletes de tu modelo

            Log::info('[PatientList] Paciente eliminado', ['id' => $id, 'nombre' => $nombre]);

            // Si la página quedó vacía, retrocede
            if ($this->page > 1 && $this->currentPageCount() === 0) {
                $this->previousPage();
            }

            // Refrescar tabla
            $this->dispatch('$refresh');

            // Toast OK
            $this->dispatch('swal', [
                'title' => 'Eliminado',
                'text'  => "Se eliminó «{$nombre}».",
                'icon'  => 'success',
            ]);
        } catch (\Throwable $e) {
            Log::error('[PatientList] Error al eliminar', ['id' => $id, 'msg' => $e->getMessage()]);
            $this->dispatch('swal', [
                'title' => 'Error',
                'text'  => 'No se pudo eliminar el paciente.',
                'icon'  => 'error',
            ]);
        }
    }

    private function currentPageCount(): int
    {
        return Paciente::search($this->search)
            ->when($this->admin !== '', fn ($q) => $q->where('is_admin', $this->admin))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage, page: $this->page)
            ->count();
    }

    public function updatedSearch() { $this->resetPage(); }

    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir === 'ASC') ? 'DESC' : 'ASC';
            return;
        }
        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    public function getPatientsWithTodayFinalization()
    {
        return Paciente::whereHas('disases', function ($q) {
                $q->whereDate('disase_paciente.fecha_finalizacion_licencia', now()->toDateString());
            })
            ->when($this->admin !== '', fn ($q) => $q->where('is_admin', $this->admin))
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
    }

    public function getPacientesAgrupadosPorTipoLicencia()
    {
        return \App\Models\Tipolicencia::with([
            'disases_paciente' => function ($q) {
                $q->whereNotNull('fecha_finalizacion_licencia')
                  ->whereDate('fecha_finalizacion_licencia', '>=', now())
                  ->with('paciente');
            }
        ])->get();
    }

    public function render()
    {
        return view('livewire.patient.patient-list', [
            'pacientes' => Paciente::with(['jerarquias','estados','ciudades'])
                ->search($this->search)
                ->when($this->admin !== '', fn ($q) => $q->where('is_admin', $this->admin))
                ->orderBy($this->sortBy, $this->sortDir)
                ->paginate($this->perPage),

            'pacientesConFinalizacionHoy' => $this->getPatientsWithTodayFinalization(),
            'agrupadosPorLicencia'        => $this->getPacientesAgrupadosPorTipoLicencia(),
        ]);
    }
}
