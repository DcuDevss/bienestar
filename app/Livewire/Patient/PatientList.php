<?php

namespace App\Livewire\Patient;

use App\Models\Paciente;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use Livewire\Attributes\Url;



class PatientList extends Component
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

    public function delete(Paciente $paciente){
        $paciente->delete();
    }



    public function updatedSearch(){
        $this->resetPage();
    }

    public function setSortBy($sortByField){

        if($this->sortBy === $sortByField){
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = $sortByField;
        $this->sortDir = 'DESC';
    }

    // ... (otros métodos)

public function getPatientsWithTodayFinalization()
{
    return Paciente::whereHas('disases', function ($query) {
        $query->whereDate('disase_paciente.fecha_finalizacion_licencia', now()->toDateString());
    })
    ->when($this->admin !== '', function ($query) {
        $query->where('is_admin', $this->admin);
    })
    ->orderBy($this->sortBy, $this->sortDir)
    ->paginate($this->perPage);
}

// ... (otros métodos)

public function render()
{
    return view('livewire.patient.patient-list', [
        'pacientes' => Paciente::search($this->search)
            ->when($this->admin !== '', function ($query) {
                $query->where('is_admin', $this->admin);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage),
        'pacientesConFinalizacionHoy' => $this->getPatientsWithTodayFinalization(),
    ]);
}



}
