<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Paciente;

class MultiformController extends Component
{ public $color;

    public $apellido_nombre;
    public $dni;
    public $cuil;
    public $direccion;
    public $genero;
    public $email;
    public $telefono;

    public $escalafon;
    public $jerarquia;
    public $legajo;
    public $destino_actual;
    public $ciudad;
    public $edad;

    public $fecha_nacimiento;
    public $peso;
    public $altura;

    public $estado_id;
    public $factore_id;
    public $jerarquia_id;
    public $comisaria_servicio;
    public $fecha_atencion;
    public $enfermedad;
    public $remedios;

    public $step;

    public $customer;

    private $stepActions = [
        'submit1',
        'submit2',
        'submit3',
    ];

    public function mount()
    {
        $this->step = 0;
    }

    public function decreaseStep()
    {
        $this->step--;
    }

    public function submit()
    {

        $action = $this->stepActions[$this->step];

        $this->$action();
    }

    public function submit1()
    {
        $this->validate([
            'apellido_nombre' => 'required',
            'dni' => 'required',
            'cuil' => 'required',
            'genero' => 'required',
            'direccion' => 'required',
            'email' => 'required',
            'telefono' => 'required',

        ]);

        if ($this->customer) {
            $this->customer= tap($this->customer)->update(['apellido_nombre' => $this->apellido_nombre]);
            session()->flash('message', 'Customer successfully updated.');

        }else {
            $this->customer = Paciente::create(['apellido_nombre' => $this->apellido_nombre]);
            session()->flash('message', 'Customer successfully created.');

        }

        $this->step++;
    }

    public function submit2()
    {
        $this->validate([
            'escalafon' => 'required',
            'legajo' => 'required',
            'jerarquia' => 'required',
            'destino_actual' => 'required',
            'ciudad' => 'required',
            'edad' => 'required',
        ]);

        $this->customer = tap($this->customer)->update(['escalafon' => $this->escalafon]);

        $this->step++;
    }
    public function submit3()
    {
        $this->validate([
            'fecha_nacimiento' => 'required',
            'peso' => 'required',
            'altura' => 'required',
        ]);

        $this->customer = tap($this->customer)->update(['fecha_nacimiento' => $this->fecha_nacimiento]);

        session()->flash('message', 'Wow! '. $this->customer->fecha_nacimiento .' is nice fecha_nacimiento '. $this->customer->fecha_nacimiento);

        $this->step++;

    }



    public function render()
    {
        return view('livewire.doctor.multiform-controller')->layout('layouts.app');
    }
}
