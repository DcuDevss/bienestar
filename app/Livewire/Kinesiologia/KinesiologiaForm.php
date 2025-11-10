<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\Paciente;
use App\Models\FichaKinesiologica;
use App\Models\RegistroSesion;
use App\Models\Doctor;
use App\Models\ObraSocial;
use App\Models\Especialidade;
use Livewire\Attributes\Rule;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class KinesiologiaForm extends Component
{
    public $showDoctorAlert = false;
    public $showEspecialidadAlert = false;

    public Paciente $paciente;
    public FichaKinesiologica $ficha;

    public $obra_social_id;

    // Datos del médico
    public $doctor_name = ''; // Lo usaremos como campo de entrada principal.
    public $doctor_matricula = ''; // Se rellenará automáticamente o se usará para agregar.
    public $doctor_especialidad = ''; // Se rellenará automáticamente o se usará para agregar.
    public $doctor_id = null; // ID del doctor seleccionado/existente.

    // Variables de control
    /* public $showDoctorAlert = false; */
    public $doctorsFound = []; // NUEVA: Para almacenar los resultados de la búsqueda.

    // Especialidades
    public $especialidades;

    // === Datos clínicos ===
    public $diagnostico = '';
    public $motivo_consulta = '';
    public $posturas_dolorosas;
    public $realiza_actividad_fisica = false;
    public $tipo_actividad;
    public $antecedentes_enfermedades;
    public $antecedentes_familiares;
    public $cirugias;
    public $traumatismos_accidentes;
    public $tratamientos_previos;
    public $menarca = false;
    public $menopausia = false;
    public $partos;
    public $estado_salud_general;
    public $alteracion_peso = false;
    public $medicacion_actual;
    public $observaciones_generales_anamnesis;

    // === Examen EOM ===
    public $visceral_palpacion;
    public $visceral_dermalgias;
    public $visceral_triggers;
    public $visceral_fijaciones;
    public $craneal_forma;
    public $craneal_triggers;
    public $craneal_fijaciones;
    public $craneal_musculos;
    public $tension_arterial;
    public $pulsos;
    public $auscultacion;
    public $ecg;
    public $ecodoppler;

    // === Sesiones ===
    public $registroSesiones;
    #[Rule('required|date')] public $nueva_sesion_fecha;
    #[Rule('required|string|min:10')] public $nueva_sesion_tratamiento;

    public $doctores;
    public $obrasSociales;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;

        // Inicializamos una ficha vacía
        $this->ficha = new FichaKinesiologica();
        $this->ficha->paciente_id = $paciente->id;

        // Cargar valores por defecto
        foreach ($this->ficha->getAttributes() as $key => $value) {
            if (property_exists($this, $key)) {
                $this->$key = $value;
            }
        }

        $this->doctores = Doctor::orderBy('name')->get();
        $this->obrasSociales = ObraSocial::orderBy('nombre')->get();
        $this->especialidades = Especialidade::orderBy('name')->pluck('name')->toArray();

        $this->registroSesiones = RegistroSesion::where('paciente_id', $paciente->id)
            ->orderBy('fecha_sesion', 'desc')
            ->get();
    }

    // ====================
    // MÉTODOS DOCTOR
    // ====================

    /**
     * Se ejecuta automáticamente cuando la propiedad $doctor_name cambia.
     * Implementa la lógica de búsqueda y alerta.
     */
    public function updatedDoctorName($value)
    {
        // 1. Limpiar resultados si el campo está vacío o muy corto
        $this->doctorsFound = [];
        $this->doctor_id = null; // Reiniciamos el ID para forzar una nueva selección
        $this->showDoctorAlert = false;

        $searchTerm = trim($value);

        if (strlen($searchTerm) < 3) {
            return;
        }

        // 2. Buscar doctores por nombre (case-insensitive)
        $this->doctorsFound = Doctor::where('name', 'like', '%' . $searchTerm . '%')
            ->limit(5)
            ->get();

        // 3. Determinar si mostrar la alerta de "agregar"
        if ($this->doctorsFound->isEmpty()) {
            // Si no hay resultados, preparamos la alerta de agregar.
            $this->showDoctorAlert = true;
            // No limpiamos el nombre, solo la matrícula y especialidad
            $this->doctor_matricula = '';
            $this->doctor_especialidad = '';
        } else {
            $this->showDoctorAlert = false;
        }
    }

    /**
     * Se llama cuando el usuario selecciona un doctor de la lista de sugerencias.
     */
    public function selectDoctor($doctorId)
    {
        $doctor = Doctor::find($doctorId);

        if ($doctor) {
            $this->doctor_id = $doctor->id;
            $this->doctor_name = $doctor->name;
            $this->doctor_matricula = $doctor->nro_matricula;
            $this->doctor_especialidad = $doctor->especialidad;
            $this->doctorsFound = []; // Ocultar la lista de sugerencias
            $this->showDoctorAlert = false; // Ocultar la alerta de agregar

            // Puedes usar dispatch en lugar de session()->flash si quieres un toast/modal en el front
            $this->dispatch('doctorSelected', $doctor->name);
        }
    }

    public function crearDoctor()
    {
        Log::info("🆕 Creando nuevo doctor", [
            'name' => $this->doctor_name,
            'matricula' => $this->doctor_matricula,
            'especialidad' => $this->doctor_especialidad,
        ]);

        $doctor = Doctor::create([
            'name' => $this->doctor_name,
            'nro_matricula' => $this->doctor_matricula,
            'especialidad' => $this->doctor_especialidad,
        ]);

        $this->doctor_id = $doctor->id;
        $this->showDoctorAlert = false;

        Log::info("✅ Doctor creado correctamente", ['doctor_id' => $doctor->id]);
        session()->flash('message', 'Doctor agregado con éxito.');
    }

    // ====================
    // MÉTODOS ESPECIALIDAD
    // ====================

    public function verificarEspecialidad()
    {
        if (empty($this->doctor_especialidad)) {
            $this->showEspecialidadAlert = false;
            return;
        }

        $existe = Especialidade::where('name', 'like', trim($this->doctor_especialidad))->first();
        $this->showEspecialidadAlert = !$existe;
    }

    public function crearEspecialidad()
    {
        Log::info("🆕 Creando nueva especialidad", ['name' => $this->doctor_especialidad]);

        $this->validate([
            'doctor_especialidad' => 'required|string|max:255|unique:especialidades,name',
        ]);

        $nueva = Especialidade::create([
            'name' => trim($this->doctor_especialidad),
            'slug' => Str::slug($this->doctor_especialidad),
            'descripcion' => '',
        ]);

        $this->especialidades = Especialidade::orderBy('name')->pluck('name')->toArray();
        $this->showEspecialidadAlert = false;

        Log::info("✅ Especialidad creada correctamente", ['id' => $nueva->id]);
        session()->flash('message', 'Especialidad creada correctamente.');
    }

    // ====================
    // MÉTODO GUARDAR FICHA
    // ====================

    public function saveFichaKinesiologica()
    {
        Log::info("💾 INICIANDO Guardado de ficha kinesiológica para paciente", [
            'paciente_id' => $this->paciente->id
        ]);

        try {
            $this->validate([
                'doctor_name' => 'required|string|max:255',
                'doctor_matricula' => 'required|string|max:50',
                'doctor_especialidad' => 'required|string|max:100',
                'obra_social_id' => 'nullable|exists:obra_socials,id',
                'diagnostico' => 'required|string|max:255',
                'motivo_consulta' => 'required|string',
                'partos' => 'nullable|integer',
                'estado_salud_general' => 'nullable|in:Bueno,Medio,Malo',
                'posturas_dolorosas' => 'nullable|string|max:500',
                'tipo_actividad' => 'nullable|string|max:255',
                'antecedentes_enfermedades' => 'nullable|string',
                'antecedentes_familiares' => 'nullable|string',
                'cirugias' => 'nullable|string',
                'traumatismos_accidentes' => 'nullable|string',
                'tratamientos_previos' => 'nullable|string',
                'medicacion_actual' => 'nullable|string',
                'observaciones_generales_anamnesis' => 'nullable|string',
                'visceral_palpacion' => 'nullable|string|max:500',
                'tension_arterial' => 'nullable|string|max:20',
            ]);

            // Buscar o crear/actualizar doctor
            if (!empty($this->doctor_id)) {
                // Opción 1: El doctor ya existe y fue seleccionado
                $doctor = Doctor::find($this->doctor_id);
            } else {
                // Opción 2: El doctor fue recién creado (por crearDoctor) 
                // o estamos usando la matrícula/nombre para buscar/crear si es el primer guardado
                $doctor = Doctor::updateOrCreate(
                    ['nro_matricula' => trim($this->doctor_matricula)],
                    [
                        'name' => trim($this->doctor_name),
                        'especialidad' => trim($this->doctor_especialidad),
                        // Aquí usamos la matrícula como clave de búsqueda/creación
                    ]
                );
            }

            $this->doctor_id = $doctor->id; // Aseguramos el ID para la ficha

            // Crear ficha
            $data = $this->only((new FichaKinesiologica())->getFillable());
            $data['paciente_id'] = $this->paciente->id;
            $data['doctor_id'] = $doctor->id;

            $this->ficha = FichaKinesiologica::create($data);

            Log::info("✅ FINALIZADO. Ficha guardada correctamente", [
                'ficha_id' => $this->ficha->id
            ]);

            $this->dispatch('swal', [
                'title' => 'Ficha guardada',
                'text' => 'Se ha guardado la ficha correctamente.',
                'icon' => 'success',
                'timer' => 3000
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $msg = collect($e->validator->errors()->all())->implode(' | ');
            $this->dispatch('swal', [
                'title' => 'Revisá los campos',
                'text' => $msg,
                'icon' => 'error',
                'timer' => 5000
            ]);
            throw $e;
        } catch (\Throwable $e) {
            Log::error("❌ Error guardando ficha", ['error' => $e->getMessage()]);
            $this->dispatch('swal', [
                'title' => 'Ups!',
                'text' => 'Ocurrió un error al guardar la ficha.',
                'icon' => 'error',
                'timer' => 5000
            ]);
        }
    }

    public function render()
    {
        return view('livewire.kinesiologia.kinesiologia-form', [
            'doctores' => $this->doctores,
            'obrasSociales' => $this->obrasSociales,
            /* 'registroSesiones' => $this->registroSesiones, */
            'especialidades' => $this->especialidades,
        ])->layout('layouts.app');
    }
}
