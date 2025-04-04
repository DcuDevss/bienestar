<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Customer;
use App\Models\Estado;
use App\Models\Factore;
use App\Models\Paciente;
use App\Models\Jerarquia;

class MultiformController extends Component
{ public $color;

    public $apellido_nombre;
    public $dni;
    public $cuil;
    public $domicilio;
    public $sexo = '';
    public $email;
    public $TelefonoCelular;

    public $jerarquia;
    public $legajo;
    public $destino_actual;
    public $ciudad;
    public $edad;

    public $fecha_nacimiento;
    public $peso;
    public $altura;

    public $estado_id = '';
    public $factore_id;
    public $jerarquia_id = '';
    public $comisaria_servicio;
    public $fecha_atencion;
    public $enfermedad;
    public $remedios;

    public $step;
    public $estados;
    public $factores;
    public $FecIngreso;
    public $NroCredencial;
    public $antiguedad;
    public $chapa;
    public $jerarquias;

    public $customer;
    public $registroCompletado = false;

    private $stepActions = [
        'submit1',
        'submit2',
        'submit3',
    ];

    public function mount()
    {
        $this->step = 0;
        $this->estados = Estado::all(); // Obtener todos los estados
        $this->factores = Factore::all();
        $this->jerarquias = Jerarquia::all();

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
            'dni' => 'required|numeric',
            'cuil' => 'required',
            'sexo' => 'required',
            'domicilio' => 'required',
            'fecha_nacimiento' => 'required',
            'email' => 'required|email',
            'TelefonoCelular' => 'required|numeric',
        ]);


        if ($this->customer) {
            $this->customer = tap($this->customer)->update([
                'apellido_nombre' => $this->apellido_nombre,
                'dni' => $this->dni,
                'cuil' => $this->cuil,
                'sexo' => $this->sexo,
                'domicilio' => $this->domicilio,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'email' => $this->email,
                'TelefonoCelular' => $this->TelefonoCelular,
                'FecIngreso' => $this->FecIngreso,
            ]);

            session()->flash('message', 'Paciente reistrado correctamente.');
        } else {
            $this->customer = Paciente::create([
                'apellido_nombre' => $this->apellido_nombre,
                'dni' => $this->dni,
                'cuil' => $this->cuil,
                'sexo' => $this->sexo,
                'domicilio' => $this->domicilio,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'email' => $this->email,
                'TelefonoCelular' => $this->TelefonoCelular,
                'FecIngreso' => $this->FecIngreso,
            ]);

            session()->flash('message', 'Paciente reistrado correctamente.');
        }

        $this->step++;

    }


    // ...

public function submit2()
{
    $this->validate([
        'legajo' => 'required',
        'jerarquia_id' => 'required',
        'destino_actual' => 'required',
        'ciudad' => 'required',
        'edad' => 'required',
        'estado_id' => 'required', // Agregar validación para el estado_id
        'NroCredencial' => 'required',
        'antiguedad' => 'required',
        'chapa' => 'required',
    ]);


    $this->customer = tap($this->customer)->update([
        'legajo' => $this->legajo,
        'jerarquia_id' => $this->jerarquia_id,
        'destino_actual' => $this->destino_actual,
        'ciudad' => $this->ciudad,
        'edad' => $this->edad,
        'estado_id' => $this->estado_id, // Incluir estado_id en la actualización
        'NroCrendecial' => $this->NroCredencial,
        'antiguedad' => $this->antiguedad,
        'chapa' => $this->chapa,
    ]);

    $this->step++;
}

// ...


    public function submit3()
    {
        $this->validate([
            'peso' => 'required',
            'altura' => 'required',
            'factore_id'=> 'required',
            'enfermedad'=>'required',
            'remedios'=>'required',
        ]);

        $this->customer = tap($this->customer)->update([
            'peso' => $this->peso,
            'altura' => $this->altura,
            'factore_id' => $this->factore_id,
            'enfermedad' => $this->enfermedad,
            'remedios' => $this->remedios,
        ]);

        session()->flash('message', 'Wow! ' . $this->customer->fecha_nacimiento . ' is nice fecha_nacimiento ' . $this->customer->fecha_nacimiento);

        // Marcar como completado el registro
        $this->registroCompletado = true;

        $this->step++;
    }



    public function render()
    {
        return view('livewire.doctor.multiform-controller')->layout('layouts.app');
    }
}
