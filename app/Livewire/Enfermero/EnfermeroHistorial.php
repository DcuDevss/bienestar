<?php

namespace App\Livewire\Enfermero;

use App\Models\ControlEnfermero;
use App\Models\Paciente;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;

class EnfermeroHistorial extends Component
{
    use WithPagination;

    #[Url(history:true)] public $search = '';
    #[Url(history:true)] public $admin = '';
    #[Url(history:true)] public $sortBy = 'id';
    #[Url(history:true)] public $sortDir = 'ASC';
    #[Url()] public $perPage = 8;

    public $pacienteId;
    public $editForm = [];
    public $editModal = false;
    public $editControl = [];

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
    }

    /** Abre modal para editar un control */
    public function openEditModal($id)
    {
        $control = ControlEnfermero::findOrFail($id);

        $this->editControl = [
            'id'             => $control->id,

            // NUEVOS (tipolibres)
            'peso'           => (string) ($control->peso ?? ''),
            'altura'         => (string) ($control->altura ?? ''),
            'talla'          => (string) ($control->talla ?? ''),

            'presion'        => (string) ($control->presion ?? ''),
            'glucosa'        => (string) ($control->glucosa ?? ''),
            'temperatura'    => (string) ($control->temperatura ?? ''), // ahora texto
            'dosis'          => (string) ($control->dosis ?? ''),
            'inyectable'     => (string) ($control->inyectable ?? ''),
            // Si preferís datetime-local, usar ->format('Y-m-d\TH:i'); el form usa <input type="date">
            'fecha_atencion' => $control->fecha_atencion
                ? Carbon::parse($control->fecha_atencion)->format('Y-m-d')
                : null,
            'detalles'       => (string) ($control->detalles ?? ''),
        ];

        $this->editForm = $control->toArray();
        $this->editModal = true;
    }

    /** Guarda la edición */
    public function updateTratamiento()
    {
        $control = ControlEnfermero::findOrFail($this->editForm['id']);

        $campos = [
            'peso','altura','talla',
            'presion','glucosa','temperatura','inyectable','dosis','fecha_atencion','detalles'
        ];

        // Copiamos del editControl al editForm
        foreach ($campos as $campo) {
            if (array_key_exists($campo, $this->editControl)) {
                $this->editForm[$campo] = $this->editControl[$campo];
            }
        }

        // Normalizamos: '' => null
        foreach ($campos as $c) {
            if (isset($this->editForm[$c]) && $this->editForm[$c] === '') {
                $this->editForm[$c] = null;
            }
        }

        // Fecha: sólo formatear si viene no nula
        if (!empty($this->editForm['fecha_atencion'])) {
            $this->editForm['fecha_atencion'] = \Carbon\Carbon::parse($this->editForm['fecha_atencion'])->format('Y-m-d');
        } else {
            $this->editForm['fecha_atencion'] = null;
        }

        $control->update([
            'peso'           => $this->editForm['peso']           ?? null,
            'altura'         => $this->editForm['altura']         ?? null,
            'talla'          => $this->editForm['talla']          ?? null,
            'presion'        => $this->editForm['presion']        ?? null,
            'glucosa'        => $this->editForm['glucosa']        ?? null,
            'temperatura'    => $this->editForm['temperatura']    ?? null,
            'inyectable'     => $this->editForm['inyectable']     ?? null,
            'dosis'          => $this->editForm['dosis']          ?? null,
            'fecha_atencion' => $this->editForm['fecha_atencion'] ?? null,
            'detalles'       => $this->editForm['detalles']       ?? null,
        ]);

        $this->editModal = false;
        $this->dispatch('swal', title: 'Actualizado', text: 'Tratamiento actualizado correctamente.', icon: 'success');
    }


    /** Confirmación con SweetAlert */
    public function confirmDelete($id)
    {
        $this->dispatch('confirm', [
            'title'       => '¿Eliminar control?',
            'text'        => 'Esta acción no se puede deshacer.',
            'icon'        => 'warning',
            'confirmText' => 'Sí, eliminar',
            'cancelText'  => 'Cancelar',
            'action'      => 'do-delete-control',
            'id'          => $id,
        ]);
    }

    /** Eliminación real */
    public function delete($id)
    {
        $control = ControlEnfermero::find($id);
        if ($control) {
            $control->delete();
            $this->dispatch('swal', title: 'Eliminado', text: 'Control eliminado correctamente.', icon: 'success');
        } else {
            $this->dispatch('swal', title: 'No encontrado', text: 'El control ya no existe.', icon: 'error');
        }
    }

    public function render()
    {
        $query = ControlEnfermero::where('paciente_id', $this->pacienteId);

        if ($this->search) {
            $like = '%'.$this->search.'%';
            $query->where(function ($q) use ($like) {
                $q->where('presion', 'like', $like)
                  ->orWhere('temperatura', 'like', $like)
                  ->orWhere('glucosa', 'like', $like)
                  ->orWhere('inyectable', 'like', $like)
                  ->orWhere('dosis', 'like', $like)
                  ->orWhere('fecha_atencion', 'like', $like)
                  ->orWhere('detalles', 'like', $like)
                  // NUEVOS en búsqueda
                  ->orWhere('peso', 'like', $like)
                  ->orWhere('altura', 'like', $like)
                  ->orWhere('talla', 'like', $like);
            });
        }

        $controles = $query->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);

        return view('livewire.enfermero.enfermero-historial', [
            'controles' => $controles
        ])->layout('layouts.app');
    }
}
