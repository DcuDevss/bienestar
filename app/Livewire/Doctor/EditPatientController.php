<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\Estado;
use App\Models\Factore;
use App\Models\Jerarquia;
use App\Models\Ciudade;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\On;

class EditPatientController extends Component
{
    public $customerId;

    // Datos personales
    public $apellido_nombre;
    public $dni;
    public $cuil;
    public $domicilio;
    public $sexo = '';
    public $email;
    public $TelefonoCelular;
    public $fecha_nacimiento;
    public $FecIngreso;

    // Datos laborales
    public $legajo;
    public $jerarquia_id;
    public $destino_actual;
    public $ciudad_id;
    public $ciudades;
    public $edad;
    public $estado_id;
    public $NroCredencial;
    public $antiguedad;
    public $chapa;

    // Salud
    public $peso;
    public $altura;
    public $factore_id;
    public $enfermedad;
    public $remedios;

    // Catálogos
    public $estados = [];
    public $factores = [];
    public $jerarquias = [];

    /* ==== Reglas y mensajes (para validate() y validateOnly()) ==== */
    protected $rules = [
        'apellido_nombre'   => 'nullable|string|max:255',
        'dni'               => 'nullable|integer',
        'cuil'              => 'nullable|integer',
        'sexo'              => 'nullable|string|in:Masculino,Femenino',
        'domicilio'         => 'nullable|string|max:255',
        'fecha_nacimiento'  => 'nullable|date',
        'email'             => 'nullable|email|max:255',
        'TelefonoCelular'   => 'nullable|string|max:20',
        'FecIngreso'        => 'nullable|date',

        'legajo'            => 'nullable|integer',
        'jerarquia_id'      => 'nullable|integer|exists:jerarquias,id',
        'destino_actual'    => 'nullable|string|max:255',
        'ciudad_id'         => 'nullable|integer|exists:ciudades,id', // edición: NO required
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
    ];

    protected $messages = [
        'ciudad_id.required' => 'La ciudad es obligatoria.',
        'ciudad_id.integer'  => 'El campo ciudad debe ser numérico.',
        'ciudad_id.exists'   => 'La ciudad seleccionada no es válida.',
        'jerarquia_id.exists'=> 'La jerarquía seleccionada no es válida.',
        'estado_id.exists'   => 'El estado seleccionado no es válido.',
        'factore_id.exists'  => 'El factor sanguíneo seleccionado no es válido.',
        'altura.numeric'     => 'Altura debe ser numérica (ej. 1.75).',
        'peso.numeric'       => 'Peso debe ser numérico (ej. 80).',
        'email.email'        => 'Ingresá un email válido.',
        'sexo.in'            => 'Sexo debe ser Masculino o Femenino.',
    ];

    public function mount($customerId)
    {
        $this->customerId = $customerId;

        $this->loadPatientData();

        $this->estados    = Estado::all();
        $this->factores   = Factore::all();
        $this->jerarquias = Jerarquia::all();
        $this->ciudades   = Ciudade::all();
    }

    public function loadPatientData()
    {
        $customer = Paciente::findOrFail($this->customerId);

        // Personales
        $this->apellido_nombre  = $customer->apellido_nombre;
        $this->dni              = $customer->dni;
        $this->cuil             = $customer->cuil;
        $this->sexo             = $this->normalizeSexo($customer->sexo); // normalizamos al montar
        $this->domicilio        = $customer->domicilio;
        $this->fecha_nacimiento = $customer->fecha_nacimiento;
        $this->email            = $customer->email;
        $this->TelefonoCelular  = $customer->TelefonoCelular;
        $this->FecIngreso       = $customer->FecIngreso;

        // Laborales
        $this->legajo           = $customer->legajo;
        $this->jerarquia_id     = $customer->jerarquia_id;
        $this->destino_actual   = $customer->destino_actual;
        $this->ciudad_id        = $customer->ciudad_id;
        $this->edad             = $customer->edad;
        $this->estado_id        = $customer->estado_id;
        $this->NroCredencial    = $customer->NroCredencial;
        $this->antiguedad       = $customer->antiguedad;
        $this->chapa            = $customer->chapa;

        // Salud
        $this->peso             = $customer->peso;
        $this->altura           = $customer->altura;
        $this->factore_id       = $customer->factore_id;
        $this->enfermedad       = $customer->enfermedad;
        $this->remedios         = $customer->remedios;
    }

    /* ===== Helpers de normalización y logging ===== */
    private function nullifyEmpty(array $attrs): void
    {
        foreach ($attrs as $a) {
            if (property_exists($this, $a) && $this->{$a} === '') {
                $this->{$a} = null;
            }
        }
    }

    private function normalizeSexo(?string $raw): ?string
    {
        if ($raw === null) return null;
        $raw = strtoupper(trim($raw));
        return match ($raw) {
            'M', 'MASC', 'MASCULINO' => 'Masculino',
            'F', 'FEM', 'FEMENINO'   => 'Femenino',
            default                  => $raw,
        };
    }

    private function normalizeNumericos(): void
    {
        // coma -> punto para numéricos decimales
        foreach (['altura','peso'] as $n) {
            if (isset($this->{$n}) && is_string($this->{$n})) {
                $v = str_replace(',', '.', trim($this->{$n}));
                $this->{$n} = ($v === '') ? null : $v;
            }
        }
        // enteros en blanco -> null
        foreach (['dni','cuil','legajo','jerarquia_id','ciudad_id','edad','estado_id','NroCredencial','antiguedad','chapa','factore_id'] as $i) {
            if (isset($this->{$i}) && $this->{$i} === '') {
                $this->{$i} = null;
            }
        }
    }

    private function logState(string $context = 'state')
    {
        Log::debug("[EditPatientController] {$context}", [
            'customerId'      => $this->customerId,
            // personales
            'apellido_nombre' => $this->apellido_nombre,
            'dni'             => $this->dni,
            'cuil'            => $this->cuil,
            'sexo'            => $this->sexo,
            'domicilio'       => $this->domicilio,
            'fecha_nacimiento'=> $this->fecha_nacimiento,
            'email'           => $this->email,
            'TelefonoCelular' => $this->TelefonoCelular,
            'FecIngreso'      => $this->FecIngreso,
            // laborales
            'legajo'          => $this->legajo,
            'jerarquia_id'    => $this->jerarquia_id,
            'destino_actual'  => $this->destino_actual,
            'ciudad_id'       => $this->ciudad_id,
            'edad'            => $this->edad,
            'estado_id'       => $this->estado_id,
            'NroCredencial'   => $this->NroCredencial,
            'antiguedad'      => $this->antiguedad,
            'chapa'           => $this->chapa,
            // salud
            'peso'            => $this->peso,
            'altura'          => $this->altura,
            'factore_id'      => $this->factore_id,
            'enfermedad'      => $this->enfermedad,
            'remedios'        => $this->remedios,
            // existencia en catálogos
            'ciudad_exists'   => (bool) optional(Ciudade::find($this->ciudad_id))->id,
            'jerarquia_exists'=> (bool) optional(Jerarquia::find($this->jerarquia_id))->id,
            'estado_exists'   => (bool) optional(Estado::find($this->estado_id))->id,
            'factor_exists'   => (bool) optional(Factore::find($this->factore_id))->id,
        ]);
    }

    /* ===== Validación en vivo opcional (loguea el 1er error del campo) ===== */
    public function updated($property)
    {
        try {
            $this->validateOnly($property);
        } catch (ValidationException $e) {
            $msg = $e->validator->errors()->first($property);
            Log::info('[EditPatientController] field updated failed', [
                'field' => $property,
                'message' => $msg,
                'value' => data_get($this, $property),
            ]);
        }
    }

    // Confirmación desde la vista (opcional)
    public function confirmarGuardar()
    {
        $this->dispatch('confirm',
            title: '¿Guardar cambios?',
            text: 'Se actualizarán los datos del paciente.',
            icon: 'question',
            confirmText: 'Sí, guardar',
            cancelText: 'Cancelar',
            action: 'do-save'
        );
    }

    #[On('do-save')]
    public function submit()
    {
        Log::debug('[EditPatientController] submit() start', ['customerId' => $this->customerId]);

        // Normalización previa
        $this->nullifyEmpty([
            'apellido_nombre','dni','cuil','sexo','domicilio','fecha_nacimiento','email',
            'TelefonoCelular','FecIngreso','legajo','jerarquia_id','destino_actual','ciudad_id',
            'edad','estado_id','NroCredencial','antiguedad','chapa','peso','altura',
            'factore_id','enfermedad','remedios'
        ]);
        $this->sexo = $this->normalizeSexo($this->sexo);
        $this->normalizeNumericos();

        // Estado ANTES de validar
        $this->logState('before_validate');

        try {
            $validated = $this->validate(); // usa $rules + $messages

            Log::debug('[EditPatientController] validation OK', [
                'validated_keys' => array_keys($validated)
            ]);

            // Estado DESPUÉS de validar (por si hubo coerciones)
            $this->logState('after_validate');

            $customer = Paciente::findOrFail($this->customerId);
            Log::debug('[EditPatientController] model loaded', ['id' => $customer->id]);

            $before = $customer->getAttributes();

            // Asignaciones
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

            $this->dispatch('swal', title: 'Guardado', text: 'Paciente actualizado correctamente.', icon: 'success');

            Log::debug('[EditPatientController] saved. changes applied', [
                'changes' => array_diff_assoc($customer->getAttributes(), $before)
            ]);

            Log::debug('[EditPatientController] submit() end');
        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            // Log global (array completo)
            Log::warning('[EditPatientController] validation FAILED (array)', [
                'errors' => $errors->toArray(),
            ]);

            // Log campo por campo
            foreach ($errors->messages() as $field => $messages) {
                foreach ($messages as $msg) {
                    Log::warning('[EditPatientController] validation FIELD', [
                        'field'   => $field,
                        'message' => $msg,
                        'value'   => data_get($this, $field),
                    ]);
                }
            }

            // Popup con detalle (HTML)
            $html = collect($errors->messages())->map(function($msgs, $field){
                $nice = str_replace('_',' ',$field);
                return '<b>'.e($nice).'</b>: '.e(implode(' | ', $msgs));
            })->implode('<br>');

            $this->dispatch('swal', title: 'Revisá los campos', html: $html, icon: 'error');

            // Estado cuando falla validación
            $this->logState('on_validation_failed');

            return;
        } catch (\Throwable $e) {
            Log::error('[EditPatientController] submit() error', [
                'customerId' => $this->customerId,
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            $this->dispatch('swal', title: 'Ups', text: 'Ocurrió un error inesperado.', icon: 'error');
            return;
        }
    }

    // Navegación opcional: confirmar salir sin guardar
    #[On('go-dashboard')]
    public function goDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.doctor.edit-patient-controller')
            ->layout('layouts.app');
    }
}
