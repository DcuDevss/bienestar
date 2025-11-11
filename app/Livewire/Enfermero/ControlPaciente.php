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

    // NUEVOS CAMPOS
    public $peso, $altura, $talla;

    public $presion, $fecha_atencion, $detalles, $glucosa, $paciente_id,
           $inyectable, $dosis, $enfermero_id, $patient, $temperatura, $pacienteId;

    public $modal = false;

    protected $rules = [
        // NUEVOS: “tipolibres”
        'peso'           => 'nullable|string',
        'altura'         => 'nullable|string',
        'talla'          => 'nullable|string',

        'presion'        => 'nullable|string',
        'fecha_atencion' => 'nullable|date',
        'temperatura'    => 'nullable|string', // libre para evitar errores con coma/punto
        'glucosa'        => 'nullable|string', // libre
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
                // NUEVOS
                'peso'           => $this->peso,
                'altura'         => $this->altura,
                'talla'          => $this->talla,

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
                'peso','altura','talla',
                'presion','fecha_atencion','glucosa','temperatura',
                'detalles','inyectable','dosis','paciente_id'
            ]);
            $this->modal = false;

            $this->dispatch('swal', title: 'Guardado', text: 'Registro creado exitosamente.', icon: 'success');
        } catch (ValidationException $e) {
            $msg = collect($e->validator->errors()->all())->implode(' | ');
            $this->dispatch('swal', title: 'Revisá los campos', text: $msg, icon: 'error');
            throw $e;
        } catch (\Throwable $e) {
            $this->dispatch('swal', title: 'Ups', text: 'Ocurrió un error al guardar.', icon: 'error');
        }
    }

    public function render()
    {
        return view('livewire.enfermero.control-paciente');
    }
}
