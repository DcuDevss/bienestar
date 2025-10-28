<?php

namespace App\Livewire\Enfermero;

use App\Models\ControlEnfermero;
use App\Models\Paciente;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class ControlPaciente extends Component
{
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'presion';

    public $presion, $fecha_atencion, $detalles, $glucosa, $paciente_id,
           $inyectable, $dosis, $enfermero_id, $patient, $temperatura, $pacienteId;

    public $modal = false;

    protected $rules = [
        'presion'        => 'nullable',
        'fecha_atencion' => 'nullable|date',
        'temperatura'    => 'nullable|numeric',
        'glucosa'        => 'nullable|numeric',
        'detalles'       => 'nullable|string',
        'inyectable'     => 'nullable|string',
        'dosis'          => 'nullable|string',
        'paciente_id'    => 'nullable|integer',
    ];

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
        $this->patient    = $paciente;
    }

    public function addNew()
    {
        $this->resetValidation();
        $this->modal = true;
    }

    public function createControles()
    {
        try {
            $this->validate();

            ControlEnfermero::create([
                'presion'        => $this->presion,
                'fecha_atencion' => $this->fecha_atencion,
                'glucosa'        => $this->glucosa,
                'temperatura'    => $this->temperatura,
                'detalles'       => $this->detalles,
                'inyectable'     => $this->inyectable,
                'dosis'          => $this->dosis,
                'paciente_id'    => $this->pacienteId,
            ]);

            // limpiar formulario
            $this->reset([
                'presion','fecha_atencion','glucosa','temperatura',
                'detalles','inyectable','dosis','paciente_id'
            ]);
            $this->modal = false;

            // ✅ SweeetAlert éxito
            $this->dispatch('swal', title: 'Guardado', text: 'Registro creado exitosamente.', icon: 'success');
        } catch (ValidationException $e) {
            // ❌ SweetAlert error con listado simple
            $msg = collect($e->validator->errors()->all())->implode(' | ');
            $this->dispatch('swal', title: 'Revisá los campos', text: $msg, icon: 'error');
            throw $e; // para que <x-input-error> marque los inputs
        } catch (\Throwable $e) {
            $this->dispatch('swal', title: 'Ups', text: 'Ocurrió un error al guardar.', icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.enfermero.control-paciente');
    }
}
