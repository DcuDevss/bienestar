<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

use App\Models\Paciente;
use App\Models\Estado;
use App\Models\Factore;
use App\Models\Jerarquia;
use App\Models\Ciudade;

class MultiformController extends Component
{
    use WithFileUploads;

    public $color;

    // Paso 1
    public $apellido_nombre;
    public $dni;
    public $cuil;
    public $domicilio;
    public $sexo = '';
    public $email;
    public $TelefonoCelular;
    public $fecha_nacimiento;
    public $FecIngreso;

    // Foto
    public $foto;                   // archivo temporal Livewire
    public int $uploadIteration = 0; // para resetear el input file

    // Paso 2
    public $jerarquia; // (no se usa)
    public $legajo;
    public $destino_actual;
    public $ciudad_id;
    public $ciudades;
    public $edad;
    public $estado_id = '';
    public $factore_id = '';
    public $jerarquia_id = '';
    public $NroCredencial;
    public $antiguedad;
    public $chapa;
    public $jerarquias;
    public $estados;
    public $factores;

    // Paso 3
    public $comisaria_servicio;
    public $fecha_atencion;
    public $enfermedad;
    public $remedios;
    public $peso;
    public $altura;

    // Control general
    public $step;
    public $customer; // instancia Paciente creada/actualizada
    public $registroCompletado = false;

    private $stepActions = [
        'submit1',
        'submit2',
        'submit3',
    ];

    public function mount()
    {
        $this->step       = 0;
        $this->estados    = Estado::all();
        $this->factores   = Factore::all();
        $this->jerarquias = Jerarquia::all();
        $this->ciudades   = Ciudade::all();
    }

    #[On('go-previous')]
    public function decreaseStep()
    {
        $this->step = max(0, $this->step - 1);
        $this->dispatch('swal', title: 'Volviste de paso', text: 'Podés editar los datos del paso anterior.', icon: 'info');
    }

    public function submit()
    {
        $action = $this->stepActions[$this->step] ?? null;

        if (!$action || !method_exists($this, $action)) {
            $this->dispatch('swal', title: 'Paso inválido', text: 'No se pudo continuar.', icon: 'error');
            return;
        }

        $this->$action();
    }

    public function submit1()
    {
        $this->validate([
            'apellido_nombre'   => 'required|string|min:3',
            'dni'               => 'required|numeric',
            'cuil'              => 'required',
            'sexo'              => 'required|in:Masculino,Femenino',
            'domicilio'         => 'required',
            'fecha_nacimiento'  => 'required|date',
            'email'             => 'required|email',
            'TelefonoCelular'   => 'required|numeric',
            'foto'              => 'nullable|image|max:5120', // 5MB para evitar cortes
        ]);

        // Crear o actualizar paciente (sin foto todavía)
        if ($this->customer) {
            $this->customer->update([
                'apellido_nombre'  => $this->apellido_nombre,
                'dni'              => $this->dni,
                'cuil'             => $this->cuil,
                'sexo'             => $this->sexo,
                'domicilio'        => $this->domicilio,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'email'            => $this->email,
                'TelefonoCelular'  => $this->TelefonoCelular,
                'FecIngreso'       => $this->FecIngreso,
            ]);
        } else {
            $this->customer = Paciente::create([
                'apellido_nombre'  => $this->apellido_nombre,
                'dni'              => $this->dni,
                'cuil'             => $this->cuil,
                'sexo'             => $this->sexo,
                'domicilio'        => $this->domicilio,
                'fecha_nacimiento' => $this->fecha_nacimiento,
                'email'            => $this->email,
                'TelefonoCelular'  => $this->TelefonoCelular,
                'FecIngreso'       => $this->FecIngreso,
            ]);
        }

        // Guardar foto si se cargó
        if ($this->foto) {
            // borrar anterior si había
            if ($this->customer->foto && Storage::disk('public')->exists($this->customer->foto)) {
                Storage::disk('public')->delete($this->customer->foto);
            }

            $dir = "pacientes/{$this->customer->id}";
            Storage::disk('public')->makeDirectory($dir);

            $filename = uniqid() . '_' . $this->foto->getClientOriginalName();
            $path = $this->foto->storeAs($dir, $filename, 'public'); // ej: pacientes/15/xxxx.jpg

            $this->customer->foto = $path; // guardar ruta relativa (sin "public/")
            $this->customer->save();

            // limpiar input y forzar rerender del file input
            $this->reset('foto');
            $this->uploadIteration++;
        }

        // Feedback y avanzar
        session()->flash('message', 'Paciente registrado correctamente.');
        $this->dispatch('swal', title: 'Paso 1 guardado', text: 'Datos personales registrados.', icon: 'success');

        $this->step = 1; // avanzar explícitamente al PASO 2
        $this->dispatch('swal', title: 'Continuá con el Paso 2', text: 'Completá datos institucionales.', icon: 'info');
    }

    public function submit2()
    {
        $this->validate([
            'legajo'         => 'required',
            'jerarquia_id'   => 'required|exists:jerarquias,id',
            'destino_actual' => 'required',
            'ciudad_id'      => 'required|exists:ciudades,id',
            'edad'           => 'required|numeric',
            'estado_id'      => 'required|exists:estados,id',
            'NroCredencial'  => 'required',
            'antiguedad'     => 'required|numeric',
            'chapa'          => 'required',
        ]);

        $this->customer->update([
            'legajo'         => $this->legajo,
            'jerarquia_id'   => $this->jerarquia_id,
            'destino_actual' => $this->destino_actual,
            'ciudad_id'      => $this->ciudad_id,
            'edad'           => $this->edad,
            'estado_id'      => $this->estado_id,
            'NroCredencial'  => $this->NroCredencial,
            'antiguedad'     => $this->antiguedad,
            'chapa'          => $this->chapa,
        ]);

        $this->dispatch('swal', title: 'Paso 2 guardado', text: 'Datos institucionales registrados.', icon: 'success');

        $this->step = 2; // avanzar al PASO 3
        $this->dispatch('swal', title: 'Continuá con el Paso 3', text: 'Completá datos de salud.', icon: 'info');
    }

    public function submit3()
    {
        $this->validate([
            'peso'        => 'required|numeric',
            'altura'      => 'required',
            'factore_id'  => 'required|exists:factores,id',
            'enfermedad'  => 'required|string',
            'remedios'    => 'required|string',
        ]);

        $this->customer->update([
            'peso'        => $this->peso,
            'altura'      => $this->altura,
            'factore_id'  => $this->factore_id,
            'enfermedad'  => $this->enfermedad,
            'remedios'    => $this->remedios,
        ]);

        session()->flash('message', 'Registro completado correctamente.');
        $this->registroCompletado = true;

        $this->step = 3; // fin
        $this->dispatch('swal', title: '¡Listo!', text: 'El registro fue completado.', icon: 'success');
    }

    public function removePhoto()
    {
        if ($this->customer?->foto && Storage::disk('public')->exists($this->customer->foto)) {
            Storage::disk('public')->delete($this->customer->foto);
        }
        if ($this->customer) {
            $this->customer->foto = null;
            $this->customer->save();
        }
        $this->reset('foto');
        $this->uploadIteration++;
        $this->dispatch('swal', title: 'Foto eliminada', text: 'La foto del paciente fue eliminada.', icon: 'error');
    }

    #[On('go-dashboard')]
    public function goDashboard()
    {
        return redirect()->route('dashboard');
    }

    public function render()
    {
        return view('livewire.doctor.multiform-controller')
               ->layout('layouts.app');
    }
}
