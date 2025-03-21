<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Estado;
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
    public $estados;

    public $customer;

    private $stepActions = [
        'submit1',
        'submit2',
        'submit3',
    ];

    public function mount()
    {
        $this->step = 0;
        $this->estados = Estado::all(); // Obtener todos los estados

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
            $this->customer = tap($this->customer)->update([
                'apellido_nombre' => $this->apellido_nombre,
                'dni' => $this->dni,
                'cuil' => $this->cuil,
                'genero' => $this->genero,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'telefono' => $this->telefono,
            ]);
            session()->flash('message', 'Paciente reistrado correctamente.');
        } else {
            $this->customer = Paciente::create([
                'apellido_nombre' => $this->apellido_nombre,
                'dni' => $this->dni,
                'cuil' => $this->cuil,
                'genero' => $this->genero,
                'direccion' => $this->direccion,
                'email' => $this->email,
                'telefono' => $this->telefono,
            ]);
            session()->flash('message', 'Paciente reistrado correctamente.');
        }

        $this->step++;
    }


    // ...

public function submit2()
{
    $this->validate([
        'escalafon' => 'required',
        'legajo' => 'required',
        'jerarquia' => 'required',
        'destino_actual' => 'required',
        'ciudad' => 'required',
        'edad' => 'required',
        'estado_id' => 'required', // Agregar validación para el estado_id
    ]);

    $this->customer = tap($this->customer)->update([
        'escalafon' => $this->escalafon,
        'legajo' => $this->legajo,
        'jerarquia' => $this->jerarquia,
        'destino_actual' => $this->destino_actual,
        'ciudad' => $this->ciudad,
        'edad' => $this->edad,
        'estado_id' => $this->estado_id, // Incluir estado_id en la actualización
    ]);

    $this->step++;
}

// ...


    public function submit3()
    {
        $this->validate([
            'fecha_nacimiento' => 'required',
            'peso' => 'required',
            'altura' => 'required',
        ]);

        $this->customer = tap($this->customer)->update([
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'peso' => $this->peso,
            'altura' => $this->altura,
        ]);

        session()->flash('message', 'Wow! ' . $this->customer->fecha_nacimiento . ' is nice fecha_nacimiento ' . $this->customer->fecha_nacimiento);

        $this->step++;
    }



    public function render()
    {
        return view('livewire.doctor.multiform-controller')->layout('layouts.app');
    }
}
