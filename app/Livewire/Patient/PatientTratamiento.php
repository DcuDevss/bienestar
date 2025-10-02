<?php

namespace App\Livewire\Patient;

use App\Models\DerivacionPsiquiatrica;
use App\Models\Enfermedade;
use App\Models\IndicacionTerapeutica;
use App\Models\Procedencia;
use App\Models\Tipolicencia;
use App\Models\Tratamiento;
use Livewire\Component;
use App\Models\Paciente;
use Livewire\Attributes\Url;
use Livewire\WithPagination;

class PatientTratamiento extends Component
{
    public $profesional_actual;
    public $consumo_farmacos;
    public $antecedente_familiar;
    public $fecha_inicio;
    public $profesional_enterior;
    public $fecha_atencion;
    public $motivo_consulta_anterior;
    public $motivo_consulta_actual;
    public $tipolicencia_id;
    public $indicacionterapeutica_id;
    public $derivacionpsiquiatrica_id;
    public $procedencia_id;
    public $enfermedade_id;
    public $paciente_id;

    public $tipolicencias = [];
    public $procedencias = [];
    public $indicacionterapeuticas = [];
    public $derivacionpsiquiatricas = [];
    public $enfermedades = [];
    public $patient;
    public $editId;
    public $edit_consumo_farmacos;
    public $edit_antecedente_familiar;
    public $edit_fecha_atencion;
    public $edit_profesional_enterior;
    public $edit_motivo_consulta_anterior;
    public $edit_tipolicencia_id;
    public $edit_indicacionterapeutica_id;
    public $edit_derivacionpsiquiatrica_id;
    public $edit_procedencia_id;
    public $edit_enfermedade_id;
    public $edit_profesional_actual;

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

    protected $rules = [
        'consumo_farmacos' => 'nullable|string',
        'antecedente_familiar' => 'nullable|string',
        'fecha_atencion' => 'nullable|date',
        'profesional_enterior' => 'nullable|string',
        'motivo_consulta_anterior' => 'nullable|string',
        'tipolicencia_id' => 'required|exists:tipolicencias,id',
        'indicacionterapeutica_id' => 'required|exists:indicacionterapeuticas,id',
        'derivacionpsiquiatrica_id' => 'required|exists:derivacionpsiquiatricas,id',
        'procedencia_id' => 'required|exists:procedencias,id',
        'enfermedade_id' => 'required|exists:enfermedades,id',
        'pacienteId' => 'required|exists:pacientes,id',
    ];

    public function mount(Paciente $paciente)
    {
        $this->tipolicencias = Tipolicencia::all();
        $this->procedencias = Procedencia::all();
        $this->derivacionpsiquiatricas = DerivacionPsiquiatrica::all();
        $this->indicacionterapeuticas = Indicacionterapeutica::all();
        $this->enfermedades = Enfermedade::all();

        $this->pacienteId = $paciente->id;
        $this->patient = $paciente;

        $this->tipolicencia_id = null;
        $this->indicacionterapeutica_id = '';
        $this->derivacionpsiquiatrica_id = null;
        $this->procedencia_id = null;
        $this->enfermedade_id = null;
    }

    public function save()
    {
        $this->validate();

        $tratamiento = new Tratamiento();

        $tratamiento->consumo_farmacos = ($this->consumo_farmacos === '') ? null : $this->consumo_farmacos;
        $tratamiento->antecedente_familiar = ($this->antecedente_familiar === '') ? null : $this->antecedente_familiar;
        $tratamiento->fecha_atencion = ($this->fecha_atencion === '') ? null : $this->fecha_atencion;
        $tratamiento->profesional_enterior = ($this->profesional_enterior === '') ? null : $this->profesional_enterior;
        $tratamiento->motivo_consulta_anterior = ($this->motivo_consulta_anterior === '') ? null : $this->motivo_consulta_anterior;
        $tratamiento->tipolicencia_id = ($this->tipolicencia_id === '') ? null : (int) $this->tipolicencia_id;
        $tratamiento->indicacionterapeutica_id = ($this->indicacionterapeutica_id === '') ? null : (int) $this->indicacionterapeutica_id;
        $tratamiento->derivacionpsiquiatrica_id = ($this->derivacionpsiquiatrica_id === '') ? null : (int) $this->derivacionpsiquiatrica_id;
        $tratamiento->procedencia_id = ($this->procedencia_id === '') ? null : (int) $this->procedencia_id;
        $tratamiento->enfermedade_id = ($this->enfermedade_id === '') ? null : (int) $this->enfermedade_id;
        $tratamiento->paciente_id = ($this->pacienteId === '') ? null : (int) $this->pacienteId;

        $tratamiento->save();
        $this->dispatch('notify', message: 'Tratamiento creado correctamente.', type: 'success');

        $this->reset();
    }

    public function openEditModal($id)
    {
        $t = Tratamiento::findOrFail($id);
        $this->editId = $t->id;
        $this->edit_consumo_farmacos = $t->consumo_farmacos;
        $this->edit_antecedente_familiar = $t->antecedente_familiar;
        $this->edit_fecha_atencion = $t->fecha_atencion
            ? \Carbon\Carbon::parse($t->fecha_atencion)->format('Y-m-d\TH:i')
            : null;
        $this->edit_profesional_enterior = $t->profesional_enterior;
        $this->edit_motivo_consulta_anterior = $t->motivo_consulta_anterior;
        $this->edit_tipolicencia_id = $t->tipolicencia_id;
        $this->edit_indicacionterapeutica_id = $t->indicacionterapeutica_id;
        $this->edit_derivacionpsiquiatrica_id = $t->derivacionpsiquiatrica_id;
        $this->edit_procedencia_id = $t->procedencia_id;
        $this->edit_enfermedade_id = $t->enfermedade_id;
    }

    public function updateTratamiento()
    {
        $fechaConvertida = $this->edit_fecha_atencion
            ? \Carbon\Carbon::createFromFormat('Y-m-d\TH:i', $this->edit_fecha_atencion)->format('Y-m-d H:i:s')
            : null;

        $t = Tratamiento::findOrFail($this->editId);

        $t->update([
            'consumo_farmacos' => $this->edit_consumo_farmacos,
            'antecedente_familiar' => $this->edit_antecedente_familiar,
            'fecha_atencion' => $fechaConvertida,
            'profesional_enterior' => $this->edit_profesional_enterior,
            'motivo_consulta_anterior' => $this->edit_motivo_consulta_anterior,
            'tipolicencia_id' => $this->edit_tipolicencia_id,
            'indicacionterapeutica_id' => $this->edit_indicacionterapeutica_id,
            'derivacionpsiquiatrica_id' => $this->edit_derivacionpsiquiatrica_id,
            'procedencia_id' => $this->edit_procedencia_id,
            'enfermedade_id' => $this->edit_enfermedade_id,
        ]);

        $this->reset([
            'editId',
            'edit_consumo_farmacos',
            'edit_antecedente_familiar',
            'edit_fecha_atencion',
            'edit_profesional_enterior',
            'edit_motivo_consulta_anterior',
            'edit_tipolicencia_id',
            'edit_indicacionterapeutica_id',
            'edit_derivacionpsiquiatrica_id',
            'edit_procedencia_id',
            'edit_enfermedade_id',
        ]);
    }

    public function delete($id)
    {
        $tratamiento = Tratamiento::find($id);

        if ($tratamiento) {
            $tratamiento->delete();
            session()->flash('message', 'Tratamiento eliminado correctamente.');
        }
    }

    public function render()
    {
        $query = Tratamiento::where('paciente_id', $this->pacienteId);

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('profesional_enterior', 'like', '%' . $this->search . '%')
                    ->orWhere('consumo_farmacos', 'like', '%' . $this->search . '%')
                    ->orWhere('fecha_atencion', 'like', '%' . $this->search . '%')
                    ->orWhere('antecedente_familiar', 'like', '%' . $this->search . '%');
            });
        }

        $tratamientos = $query->orderBy($this->sortBy, $this->sortDir)->paginate($this->perPage);

        return view('livewire.patient.patient-tratamiento', compact('tratamientos'))->layout('layouts.app');
    }
}
