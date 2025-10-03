<?php

namespace App\Livewire\Enfermero;

use App\Models\ControlEnfermero;
use App\Models\Paciente;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Carbon\Carbon;
/* c */
class EnfermeroHistorial extends Component
{
    use WithPagination;

    #[Url(history:true)]
    public $search = '';

    #[Url(history:true)]
    public $admin = '';

    #[Url(history:true)]
    public $sortBy = 'id';

    #[Url(history:true)]
    public $sortDir = 'ASC';

    #[Url()]
    public $perPage = 8;

    public $pacienteId;

    public $editForm = [];
    public $editModal = false;
    public $editControl = [];

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
    }

    public function openEditModal($id)
    {
        $control = ControlEnfermero::findOrFail($id);

        $this->editControl = [
            'id'             => $control->id,
            'presion'        => (string) $control->presion,
            'glucosa'        => (string) $control->glucosa,
            'temperatura'    => (float) $control->temperatura,
            'dosis'          => $control->dosis,
            'inyectable'     => $control->inyectable,
            'fecha_atencion' => $control->fecha_atencion
                ? ($control->fecha_atencion instanceof \DateTimeInterface
                    ? $control->fecha_atencion->format('Y-m-d')
                    : Carbon::parse($control->fecha_atencion)->format('Y-m-d'))
                : null,
            'detalles'       => $control->detalles,
        ];

        $this->editForm = $control->toArray();
        $this->editModal = true;
    }

    public function updateTratamiento()
    {
        $control = ControlEnfermero::findOrFail($this->editForm['id']);

        $campos = ['presion','glucosa','temperatura','inyectable','dosis','fecha_atencion','detalles'];
        foreach ($campos as $campo) {
            if (array_key_exists($campo, $this->editControl)) {
                $this->editForm[$campo] = $this->editControl[$campo];
            }
        }

        if (!empty($this->editForm['fecha_atencion'])) {
            $this->editForm['fecha_atencion'] = Carbon::parse($this->editForm['fecha_atencion'])->format('Y-m-d');
        }

        $control->update([
            'presion'        => $this->editForm['presion']        ?? null,
            'glucosa'        => $this->editForm['glucosa']        ?? null,
            'temperatura'    => $this->editForm['temperatura']    ?? null,
            'inyectable'     => $this->editForm['inyectable']     ?? null,
            'dosis'          => $this->editForm['dosis']          ?? null,
            'fecha_atencion' => $this->editForm['fecha_atencion'] ?? null,
            'detalles'       => $this->editForm['detalles']       ?? null,
        ]);

        $this->editModal = false;
        session()->flash('message', 'Tratamiento actualizado correctamente.');
        $this->dispatch('notify', message: 'Tratamiento actualizado correctamente.');
    }

    public function delete($id)
    {
        ControlEnfermero::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = ControlEnfermero::where('paciente_id', $this->pacienteId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('presion', 'like', '%' . $this->search . '%')
                    ->orWhere('temperatura', 'like', '%' . $this->search . '%')
                    ->orWhere('glucosa', 'like', '%' . $this->search . '%')
                    ->orWhere('inyectable', 'like', '%' . $this->search . '%')
                    ->orWhere('dosis', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_atencion', 'like', '%' . $this->search . '%')
                    ->orWhere('detalles', 'like', '%' . $this->search . '%');
            });
        }

        $controles = $query->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);

        return view('livewire.enfermero.enfermero-historial', [
            'controles' => $controles
        ])->layout('layouts.app');
    }
}
