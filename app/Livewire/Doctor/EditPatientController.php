<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

use App\Models\Paciente;
use App\Models\Estado;
use App\Models\Factore;
use App\Models\Jerarquia;
use App\Models\Ciudade;

class EditPatientController extends Component
{
    use WithFileUploads;

    public $customerId;

    // Datos personaales
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

    // Foto
    public $foto;                    // archivo temporal
    public int $uploadIteration = 0; // para resetear el input

    /* ==== Reglas y mensajes ==== */
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
        'ciudad_id'         => 'nullable|integer|exists:ciudades,id',
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

        // 👇 regla para la foto
        'foto'              => 'nullable|image|max:5120',
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
        'foto.image'         => 'La foto debe ser una imagen.',
        'foto.max'           => 'La foto no puede superar 5MB.',
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
        $this->sexo             = $this->normalizeSexo($customer->sexo);
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

    /* ===== Helpers ===== */
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
        foreach (['altura','peso'] as $n) {
            if (isset($this->{$n}) && is_string($this->{$n})) {
                $v = str_replace(',', '.', trim($this->{$n}));
                $this->{$n} = ($v === '') ? null : $v;
            }
        }
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
            // ... (logs como ya tenías)
        ]);
    }

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

        $this->nullifyEmpty([
            'apellido_nombre','dni','cuil','sexo','domicilio','fecha_nacimiento','email',
            'TelefonoCelular','FecIngreso','legajo','jerarquia_id','destino_actual','ciudad_id',
            'edad','estado_id','NroCredencial','antiguedad','chapa','peso','altura',
            'factore_id','enfermedad','remedios'
        ]);
        $this->sexo = $this->normalizeSexo($this->sexo);
        $this->normalizeNumericos();

        $this->logState('before_validate');

        try {
            $validated = $this->validate(); // usa $rules + $messages

            $this->logState('after_validate');

            $customer = Paciente::findOrFail($this->customerId);

            $before = $customer->getAttributes();

            // Campos “no foto”
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

            $changes = array_diff_assoc($customer->getAttributes(), $before);
            audit_log('paciente.update', $customer, 'Actualización de datos del paciente: ');

            $customer->save();

            // 👇 Reemplazo de foto si se subió una nueva
            if ($this->foto) {
                // borrar anterior si existe
                if ($customer->foto && Storage::disk('public')->exists($customer->foto)) {
                    Storage::disk('public')->delete($customer->foto);
                }

                $dir = "pacientes/{$customer->id}";
                Storage::disk('public')->makeDirectory($dir);

                $filename = uniqid().'_'.$this->foto->getClientOriginalName();
                $path = $this->foto->storeAs($dir, $filename, 'public'); // pacientes/{id}/...

                $customer->foto = $path;
                $customer->save();

                $this->reset('foto');
                $this->uploadIteration++;

                audit_log('paciente.photo.uploaded', $customer, 'Se actualizó la foto del paciente');
                if ($customer->foto && Storage::disk('public')->exists($customer->foto)) {
                    Storage::disk('public')->delete($customer->foto);
                    // Audit: foto anterior eliminada (por reemplazo)
                    audit_log('paciente.photo.removed', $customer, 'Se eliminó la foto anterior (reemplazo)');
                }

            }

            $this->dispatch('swal', title: 'Guardado', text: 'Paciente actualizado correctamente.', icon: 'success');

            Log::debug('[EditPatientController] saved. changes applied', [
                'changes' => array_diff_assoc($customer->getAttributes(), $before)
            ]);

        } catch (ValidationException $e) {
            $errors = $e->validator->errors();

            Log::warning('[EditPatientController] validation FAILED (array)', [
                'errors' => $errors->toArray(),
            ]);

            foreach ($errors->messages() as $field => $messages) {
                foreach ($messages as $msg) {
                    Log::warning('[EditPatientController] validation FIELD', [
                        'field'   => $field,
                        'message' => $msg,
                        'value'   => data_get($this, $field),
                    ]);
                }
            }

            $html = collect($errors->messages())->map(function($msgs, $field){
                $nice = str_replace('_',' ',$field);
                return '<b>'.e($nice).'</b>: '.e(implode(' | ', $msgs));
            })->implode('<br>');

            $this->dispatch('swal', title: 'Revisá los campos', html: $html, icon: 'error');
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

    public function removePhoto()
    {
        $customer = Paciente::findOrFail($this->customerId);

        if ($customer->foto && Storage::disk('public')->exists($customer->foto)) {
            Storage::disk('public')->delete($customer->foto);
        }

        $customer->foto = null;
        $customer->save();

        $this->reset('foto');
        $this->uploadIteration++;
        
        audit_log('paciente.photo.removed', $customer, 'Foto de paciente eliminada manualmente');


        $this->dispatch('swal', title: 'Foto eliminada', text: 'Se quitó la foto del paciente.', icon: 'error');
    }

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
