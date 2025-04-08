<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Estado;
use App\Models\Factore;
use App\Models\Jerarquia;

class EditPatientController extends Component
{
    public $customerId; // ID del paciente a editar
    public $apellido_nombre;
    public $dni;
    public $cuil;
    public $domicilio;
    public $sexo;
    public $email;
    public $TelefonoCelular;
    public $fecha_nacimiento;
    public $FecIngreso;

    public $legajo;
    public $jerarquia_id;
    public $destino_actual;
    public $ciudad;
    public $edad;
    public $estado_id;
    public $NroCredencial;
    public $antiguedad;
    public $chapa;

    public $peso;
    public $altura;
    public $factore_id;
    public $enfermedad;
    public $remedios;

    public $estados;
    public $factores;
    public $jerarquias;

    public function mount($customerId)
    {
        $this->customerId = $customerId;

        // Cargar el paciente a editar
        $this->loadPatientData();

        // Obtener datos adicionales necesarios
        $this->estados = Estado::all();
        $this->factores = Factore::all();
        $this->jerarquias = Jerarquia::all();
    }

    public function loadPatientData()
    {
        $customer = Paciente::findOrFail($this->customerId);

        // Asignar los datos del paciente a las propiedades
        $this->apellido_nombre = $customer->apellido_nombre;
        $this->dni = $customer->dni;
        $this->cuil = $customer->cuil;
        $this->sexo = $customer->sexo;
        $this->domicilio = $customer->domicilio;
        $this->fecha_nacimiento = $customer->fecha_nacimiento;
        $this->email = $customer->email;
        $this->TelefonoCelular = $customer->TelefonoCelular;
        $this->FecIngreso = $customer->FecIngreso;

        // Si ya tiene datos en la segunda sección (ej. legajo, jerarquía, etc.)
        if ($customer->legajo) {
            $this->legajo = $customer->legajo;
            $this->jerarquia_id = $customer->jerarquia_id;
            $this->destino_actual = $customer->destino_actual;
            $this->ciudad = $customer->ciudad;
            $this->edad = $customer->edad;
            $this->estado_id = $customer->estado_id;
            $this->NroCredencial = $customer->NroCredencial;
            $this->antiguedad = $customer->antiguedad;
            $this->chapa = $customer->chapa;
        }

        // Si ya tiene datos en la tercera sección (ej. peso, altura, etc.)
        if ($customer->peso) {
            $this->peso = $customer->peso;
            $this->altura = $customer->altura;
            $this->factore_id = $customer->factore_id;
            $this->enfermedad = $customer->enfermedad;
            $this->remedios = $customer->remedios;
        }
    }

    public function submit()
    {

        // Validación de los campos
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

        // Actualizar los datos del paciente en la base de datos
        $customer = Paciente::findOrFail($this->customerId);

        $customer->update([
            'apellido_nombre' => $this->apellido_nombre,
            'dni' => $this->dni,
            'cuil' => $this->cuil,
            'sexo' => $this->sexo,
            'domicilio' => $this->domicilio,
            'fecha_nacimiento' => $this->fecha_nacimiento,
            'email' => $this->email,
            'TelefonoCelular' => $this->TelefonoCelular,
            'FecIngreso' => $this->FecIngreso,
            'legajo' => $this->legajo ?? null,
            'jerarquia_id' => $this->jerarquia_id ?? null,
            'destino_actual' => $this->destino_actual ?? null,
            'ciudad' => $this->ciudad ?? null,
            'edad' => $this->edad ?? null,
            'estado_id' => $this->estado_id ?? null,
            'NroCredencial' => $this->NroCredencial ?? null,
            'antiguedad' => $this->antiguedad ?? null,
            'chapa' => $this->chapa ?? null,
            'peso' => $this->peso ?? null,
            'altura' => $this->altura ?? null,
            'factore_id' => $this->factore_id ?? null,
            'enfermedad' => $this->enfermedad ?? null,
            'remedios' => $this->remedios ?? null,
        ]);

        return redirect()->route('interviews.index', $this->customerId);
    }

    public function render()
    {
        return view('livewire.doctor.edit-patient-controller')->layout('layouts.app');
    }
}
