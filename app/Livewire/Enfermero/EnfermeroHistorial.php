<?php


/**/
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

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
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

