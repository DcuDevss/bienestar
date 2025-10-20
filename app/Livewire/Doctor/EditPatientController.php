<?php

namespace App\Livewire\Doctor;

use App\Models\Ciudade;
use Livewire\Component;
use App\Models\Paciente;
use App\Models\Estado;
use App\Models\Factore;
use App\Models\Jerarquia;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class EditPatientController extends Component
{
    public $customerId;

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
    // public $ciudad;
    public $ciudad_id;
    public $ciudades;

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

    public $estados = [];
    public $factores = [];
    public $jerarquias = [];

    public function mount($customerId)
    {
        $this->customerId = $customerId;

        $this->loadPatientData();

        $this->estados    = Estado::all();
        $this->factores   = Factore::all();
        $this->jerarquias = Jerarquia::all();
        $this->ciudades = Ciudade::all();
    }

    public function loadPatientData()
    {
        $customer = Paciente::findOrFail($this->customerId);

        $this->apellido_nombre  = $customer->apellido_nombre;
        $this->dni              = $customer->dni;
        $this->cuil             = $customer->cuil;
        $this->sexo             = $customer->sexo;
        $this->domicilio        = $customer->domicilio;
        $this->fecha_nacimiento = $customer->fecha_nacimiento;
        $this->email            = $customer->email;
        $this->TelefonoCelular  = $customer->TelefonoCelular;
        $this->FecIngreso       = $customer->FecIngreso;

        $this->legajo           = $customer->legajo;
        $this->jerarquia_id     = $customer->jerarquia_id;
        $this->destino_actual   = $customer->destino_actual;
        // $this->ciudad           = $customer->ciudad;
        $this->ciudad_id        = $customer->ciudad_id;
        $this->edad             = $customer->edad;
        $this->estado_id        = $customer->estado_id;
        $this->NroCredencial    = $customer->NroCredencial;
        $this->antiguedad       = $customer->antiguedad;
        $this->chapa            = $customer->chapa;

        $this->peso             = $customer->peso;
        $this->altura           = $customer->altura;
        $this->factore_id       = $customer->factore_id;
        $this->enfermedad       = $customer->enfermedad;
        $this->remedios         = $customer->remedios;
    }

    public function submit()
    {
        Log::debug('[EditPatientController] submit() start', ['customerId' => $this->customerId]);

        try {
            $validated = $this->validate([
                'apellido_nombre'   => 'nullable|string|max:255',
                'dni'               => 'nullable|integer',
                'cuil'              => 'nullable|integer',
                'sexo'              => 'nullable|string',
                'domicilio'         => 'nullable|string|max:255',
                'fecha_nacimiento'  => 'nullable|date',
                'email'             => 'nullable|email|max:255',
                'TelefonoCelular'   => 'nullable|string|max:20',
                'FecIngreso'        => 'nullable|date',

                'legajo'            => 'nullable|integer',
                'jerarquia_id'      => 'nullable|integer|exists:jerarquias,id',
                'destino_actual'    => 'nullable|string|max:255',
                'ciudad_id'         => 'required|integer|exists:ciudades,id',
                'edad'              => 'nullable|integer|min:0',
                'estado_id'         => 'nullable|integer|exists:estados,id',
                'NroCredencial'     => 'nullable|integer',
                'antiguedad'        => 'nullable|integer|min:0',
                'chapa'             => 'nullable|integer',

                'peso'              => 'nullable|numeric|min:0',
                'altura'            => 'nullable|numeric|min:0',
                'factore_id'        => 'nullable|integer|exists:factores,id',
                'enfermedad'        => 'nullable|string|max:500',
                'remedios'          => 'nullable|string|max:500',
            ]);

            Log::debug('[EditPatientController] validation OK', ['validated' => array_keys($validated)]);

            $customer = Paciente::findOrFail($this->customerId);
            Log::debug('[EditPatientController] model loaded', ['id' => $customer->id]);

            $before = $customer->getAttributes();

            $customer->apellido_nombre  = $this->apellido_nombre;
            $customer->dni              = $this->dni;
            $customer->cuil             = $this->cuil;
            $customer->sexo             = $this->sexo;
            $customer->domicilio        = $this->domicilio;
            $customer->fecha_nacimiento = $this->fecha_nacimiento;
            $customer->email            = $this->email;
            $customer->TelefonoCelular  = $this->TelefonoCelular;
            $customer->FecIngreso       = $this->FecIngreso;

            $customer->legajo           = $this->legajo;
            $customer->jerarquia_id     = $this->jerarquia_id;
            $customer->destino_actual   = $this->destino_actual;
            // $customer->ciudad           = $this->ciudad;
            $customer->ciudad_id        = $this->ciudad_id;
            $customer->edad             = $this->edad;
            $customer->estado_id        = $this->estado_id;
            $customer->NroCredencial    = $this->NroCredencial;
            $customer->antiguedad       = $this->antiguedad;
            $customer->chapa            = $this->chapa;

            $customer->peso             = $this->peso;
            $customer->altura           = $this->altura;
            $customer->factore_id       = $this->factore_id;
            $customer->enfermedad       = $this->enfermedad;
            $customer->remedios         = $this->remedios;

            Log::debug('[EditPatientController] dirty before save', $customer->getDirty());

            $customer->save();

            $this->dispatch('notify', message: 'Paciente actualizado correctamente.');

            Log::debug('[EditPatientController] saved. changes applied', [
                'changes' => array_diff_assoc($customer->getAttributes(), $before)
            ]);


            Log::debug('[EditPatientController] submit() end');
        } catch (ValidationException $e) {
            Log::warning('[EditPatientController] validation FAILED', [
                'errors' => $e->validator->errors()->toArray(),
            ]);
            return;
        } catch (\Throwable $e) {
            Log::error('[EditPatientController] submit() error', [
                'customerId' => $this->customerId,
                'msg' => $e->getMessage(),
            ]);
            return;
        }
    }

    public function render()
    {
        return view('livewire.doctor.edit-patient-controller')
            ->layout('layouts.app');
    }
}
