<?php
namespace App\Livewire\Enfermero;


use App\Models\Controlenfermero;
use App\Models\Paciente;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

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
    public $editControl;

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
    }

    public function openEditModal($id)
    {
        $control = Controlenfermero::findOrFail($id);
        $this->editControl = [
        'id' => $control->id,
        'presion' => (int) $control->presion,
        'glucosa' => (int) $control->glucosa,
        'temperatura' => (float) $control->temperatura,
        'dosis' => $control->dosis,
        'inyectable' => $control->inyectable,
        'fecha_atencion' => $control->fecha_atencion,
        'detalles' => $control->detalles,
    ];
        $this->editForm = $control->toArray();
        $this->editModal = true;
    }

    public function updateTratamiento()
    {
        $control = Controlenfermero::findOrFail($this->editForm['id']);
        $control->update([
            'presion' => $this->editForm['presion'],
            'glucosa' => $this->editForm['glucosa'],
            'temperatura' => $this->editForm['temperatura'],
            'inyectable' => $this->editForm['inyectable'],
            'dosis' => $this->editForm['dosis'],
            'fecha_atencion' => $this->editForm['fecha_atencion'],
            'detalles' => $this->editForm['detalles'],
        ]);
        $this->editModal = false;
        session()->flash('message', 'Tratamiento actualizado correctamente.');
    }

    public function delete($id)
    {
        Controlenfermero::findOrFail($id)->delete();
    }

    public function render()
    {
        $query = Controlenfermero::where('paciente_id', $this->pacienteId);

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

        return view('livewire.enfermero.enfermero-historial', ['controles' => $controles])->layout('layouts.app');
    }
}
