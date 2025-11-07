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
    public $doctor_name;
    public $doctor_matricula;
    public $doctor_especialidad;
    public $doctor_id;

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
        Log::info("🟢 Entrando a mount() de KinesiologiaForm", ['paciente_id' => $paciente->id]);

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

        Log::info("✅ mount() completado correctamente");
    }

    // ====================
    // MÉTODOS DOCTOR
    // ====================
    public function verificarDoctor()
    {
        Log::info("👨‍⚕️ Ejecutando verificarDoctor()", ['doctor_name' => $this->doctor_name]);

        if (empty($this->doctor_name)) {
            $this->showDoctorAlert = false;
            return;
        }

        $doctor = Doctor::where('name', 'like', trim($this->doctor_name))->first();

        if (!$doctor) {
            Log::info("⚠️ Doctor no encontrado", ['name' => $this->doctor_name]);
            $this->showDoctorAlert = true;
        } else {
            Log::info("✅ Doctor encontrado", [
                'id' => $doctor->id,
                'matricula' => $doctor->nro_matricula,
                'especialidad' => $doctor->especialidad,
            ]);
            $this->doctor_id = $doctor->id;
            $this->doctor_matricula = $doctor->nro_matricula;
            $this->doctor_especialidad = $doctor->especialidad;
            $this->showDoctorAlert = false;
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
        Log::info("🔍 Verificando especialidad", ['especialidad' => $this->doctor_especialidad]);

        if (empty($this->doctor_especialidad)) {
            $this->showEspecialidadAlert = false;
            return;
        }

        $existe = Especialidade::where('name', 'like', trim($this->doctor_especialidad))->first();

        $this->showEspecialidadAlert = !$existe;

        if (!$existe) {
            Log::info("⚠️ Especialidad no encontrada, mostrar alerta.");
        } else {
            Log::info("✅ Especialidad existente encontrada");
        }
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
        Log::info("💾 Guardando ficha kinesiológica para paciente", ['paciente_id' => $this->paciente->id]);

        try {
            // VALIDACIÓN
            $this->validate([
                'doctor_name' => 'required|string|max:255',
                'doctor_matricula' => 'required|string|max:50',
                'doctor_especialidad' => 'required|string|max:100',
                'obra_social_id' => 'nullable|exists:obra_socials,id',
                'diagnostico' => 'required|string|max:255',
                'motivo_consulta' => 'required|string',
                'partos' => 'nullable|integer',
                'estado_salud_general' => 'nullable|in:Bueno,Medio,Malo',
            ]);

            // CREAR O ASOCIAR DOCTOR
            $doctor = Doctor::firstOrCreate(
                [
                    'name' => $this->doctor_name,
                    'nro_matricula' => $this->doctor_matricula,
                ],
                [
                    'especialidad' => $this->doctor_especialidad,
                ]
            );

            // CREAR FICHA
            $data = $this->only((new FichaKinesiologica())->getFillable());
            $data['paciente_id'] = $this->paciente->id;
            $data['doctor_id'] = $doctor->id;

            $this->ficha = FichaKinesiologica::create($data);

            Log::info("✅ Ficha guardada correctamente", ['ficha_id' => $this->ficha->id]);

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
        Log::info("🎨 Renderizando vista KinesiologiaForm");

        return view('livewire.kinesiologia.kinesiologia-form', [
            'doctores' => $this->doctores,
            'obrasSociales' => $this->obrasSociales,
            'registroSesiones' => $this->registroSesiones,
            'especialidades' => $this->especialidades,
        ])->layout('layouts.app');
    }
}
