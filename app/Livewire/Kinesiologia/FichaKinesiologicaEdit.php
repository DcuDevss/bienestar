<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\FichaKinesiologica;
use App\Models\Doctor;
use App\Models\Especialidade;
use App\Models\ObraSocial;

class FichaKinesiologicaEdit extends Component
{



    public $isEdit = false;


    public $showDoctorAlert = false;
    
    public $showEspecialidadAlert = false;
    public $doctorsFound = [];
   

    public $ficha;
    public $paciente;
    public $obrasSociales = [];
    public $especialidades = [];

    // Campos del formulario (los mismos que en creación)
    public $doctor_id, $doctor_name, $doctor_matricula, $doctor_especialidad;
    public $obra_social_id, $diagnostico, $motivo_consulta, $posturas_dolorosas,
        $realiza_actividad_fisica, $tipo_actividad, $antecedentes_enfermedades,
        $antecedentes_familiares, $cirugias, $traumatismos_accidentes, $tratamientos_previos,
        $estado_salud_general, $alteracion_peso, $medicacion_actual,
        $observaciones_generales_anamnesis, $menarca, $menopausia, $partos,
        $visceral_palpacion, $visceral_dermalgias, $visceral_triggers, $visceral_fijaciones,
        $craneal_forma, $craneal_triggers, $craneal_fijaciones, $craneal_musculos,
        $tension_arterial, $pulsos, $auscultacion, $ecg, $ecodoppler;

    public function mount($ficha)
    {
        $this->isEdit = true;
        $this->ficha = FichaKinesiologica::with('paciente', 'doctor')->findOrFail($ficha);
        $this->paciente = $this->ficha->paciente;

        // Precargar valores desde la base
        $this->fill($this->ficha->only([
            'diagnostico',
            'motivo_consulta',
            'posturas_dolorosas',
            'realiza_actividad_fisica',
            'tipo_actividad',
            'antecedentes_enfermedades',
            'antecedentes_familiares',
            'cirugias',
            'traumatismos_accidentes',
            'tratamientos_previos',
            'estado_salud_general',
            'alteracion_peso',
            'medicacion_actual',
            'observaciones_generales_anamnesis',
            'menarca',
            'menopausia',
            'partos',
            'visceral_palpacion',
            'visceral_dermalgias',
            'visceral_triggers',
            'visceral_fijaciones',
            'craneal_forma',
            'craneal_triggers',
            'craneal_fijaciones',
            'craneal_musculos',
            'tension_arterial',
            'pulsos',
            'auscultacion',
            'ecg',
            'ecodoppler',
        ]));

        $doctor = $this->ficha->doctor;
        if ($doctor) {
            $this->doctor_id = $doctor->id;
            $this->doctor_name = $doctor->name;
            $this->doctor_matricula = $doctor->nro_matricula;
            $this->doctor_especialidad = $doctor->especialidad;
        }

        $this->obra_social_id = $this->ficha->obra_social_id;
        $this->obrasSociales = ObraSocial::all();
        $this->especialidades = Especialidade::pluck('name')->toArray();
    }

    public function updateFichaKinesiologica()
    {
        $this->validate([
            'diagnostico' => 'nullable|string',
            'motivo_consulta' => 'nullable|string',
        ]);

        $this->ficha->update([
            'doctor_id' => $this->doctor_id,
            'obra_social_id' => $this->obra_social_id,
            'diagnostico' => $this->diagnostico,
            'motivo_consulta' => $this->motivo_consulta,
            'posturas_dolorosas' => $this->posturas_dolorosas,
            'realiza_actividad_fisica' => $this->realiza_actividad_fisica,
            'tipo_actividad' => $this->tipo_actividad,
            'antecedentes_enfermedades' => $this->antecedentes_enfermedades,
            'antecedentes_familiares' => $this->antecedentes_familiares,
            'cirugias' => $this->cirugias,
            'traumatismos_accidentes' => $this->traumatismos_accidentes,
            'tratamientos_previos' => $this->tratamientos_previos,
            'estado_salud_general' => $this->estado_salud_general,
            'alteracion_peso' => $this->alteracion_peso,
            'medicacion_actual' => $this->medicacion_actual,
            'observaciones_generales_anamnesis' => $this->observaciones_generales_anamnesis,
            'menarca' => $this->menarca,
            'menopausia' => $this->menopausia,
            'partos' => $this->partos,
            'visceral_palpacion' => $this->visceral_palpacion,
            'visceral_dermalgias' => $this->visceral_dermalgias,
            'visceral_triggers' => $this->visceral_triggers,
            'visceral_fijaciones' => $this->visceral_fijaciones,
            'craneal_forma' => $this->craneal_forma,
            'craneal_triggers' => $this->craneal_triggers,
            'craneal_fijaciones' => $this->craneal_fijaciones,
            'craneal_musculos' => $this->craneal_musculos,
            'tension_arterial' => $this->tension_arterial,
            'pulsos' => $this->pulsos,
            'auscultacion' => $this->auscultacion,
            'ecg' => $this->ecg,
            'ecodoppler' => $this->ecodoppler,
        ]);

        $this->dispatch('swal', ['title' => 'Ficha actualizada correctamente', 'icon' => 'success']);
        return redirect()->route('fichas-kinesiologicas.index', ['paciente' => $this->ficha->paciente_id]);
    }


    // Buscar doctores en vivo mientras escribe
public function updatedDoctorName($value)
{
    $this->showDoctorAlert = false;
    $this->doctor_id = null;

    if (strlen($value) >= 2) {
        $this->doctorsFound = Doctor::where('name', 'like', "%{$value}%")
            ->take(10)
            ->get();
    } else {
        $this->doctorsFound = [];
    }
}

// Seleccionar un doctor de la lista
public function selectDoctor($doctorId)
{
    $doctor = Doctor::find($doctorId);
    if ($doctor) {
        $this->doctor_id = $doctor->id;
        $this->doctor_name = $doctor->name;
        $this->doctor_matricula = $doctor->nro_matricula;
        $this->doctor_especialidad = $doctor->especialidad;
        $this->doctorsFound = [];
    }
}

// Crear nuevo doctor si no existe
#[\Livewire\Attributes\On('crearDoctor')]
public function crearDoctor()
{
    $this->validate([
        'doctor_name' => 'required|string|max:255',
        'doctor_matricula' => 'required|string|max:255',
        'doctor_especialidad' => 'required|string|max:255',
    ]);

    $doctor = Doctor::create([
        'name' => $this->doctor_name,
        'nro_matricula' => $this->doctor_matricula,
        'especialidad' => $this->doctor_especialidad,
    ]);

    $this->doctor_id = $doctor->id;
    $this->showDoctorAlert = false;

    $this->dispatch('swal', [
        'title' => 'Doctor creado y asignado correctamente',
        'icon' => 'success'
    ]);
}





    public function render()
    {
        return view('livewire.kinesiologia.ficha-kinesiologica-edit')
            ->layout('layouts.app'); // 👈 tu layout base
    }
}
