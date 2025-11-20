<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\FichaKinesiologica;
use App\Models\Doctor;
use App\Models\Especialidade;
use App\Models\ObraSocial;
use Carbon\Carbon;

class FichaKinesiologicaEdit extends Component
{
    // ... (otras propiedades)

    public $isEdit = false;
    public $ultimaEdicionTexto;

    public $showDoctorAlert = false;
    public $showEspecialidadAlert = false;
    public $doctorsFound = [];

    public $ficha;
    public $paciente;
    public $obrasSociales = [];
    public $especialidades = [];

    // Campos del formulario
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

        // ==========================================================
        // INICIO: LÓGICA DE CÁLCULO DE FECHA EN EL COMPONENTE
        // ==========================================================

        $updated = Carbon::parse($this->ficha->updated_at)
            ->setTimezone('America/Argentina/Buenos_Aires')
            ->locale('es');

        $diaSemana = ucfirst($updated->dayName);
        $mes = $updated->monthName;

        // Formato final: "miércoles, 19 noviembre 2025 a las 09:55 hrs."
        $this->ultimaEdicionTexto = $diaSemana . ', ' . $updated->day . ' ' . $mes . ' ' . $updated->year . ' a las ' . $updated->format('H:i') . ' hrs.';

        // ==========================================================
        // FIN: LÓGICA DE CÁLCULO DE FECHA EN EL COMPONENTE
        // ==========================================================

        $this->fill($this->ficha->only([
            'diagnostico',
            'motivo_consulta',
            'posturas_dolorosas',
            'tipo_actividad',
            'antecedentes_enfermedades',
            'antecedentes_familiares',
            'cirugias',
            'traumatismos_accidentes',
            'tratamientos_previos',
            'estado_salud_general',
            'medicacion_actual',
            'observaciones_generales_anamnesis',
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

        // CORREGIDO: convertir valores 0/1 a strings para selects
        $this->alteracion_peso          = $this->ficha->alteracion_peso !== null ? (string)$this->ficha->alteracion_peso : '';
        $this->realiza_actividad_fisica = $this->ficha->realiza_actividad_fisica !== null ? (string)$this->ficha->realiza_actividad_fisica : '';
        $this->menarca                  = $this->ficha->menarca !== null ? (string)$this->ficha->menarca : '';
        $this->menopausia               = $this->ficha->menopausia !== null ? (string)$this->ficha->menopausia : '';

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

    /**
     * Normaliza select "" → null, "0" → 0, "1" → 1
     */
    private function normalizeBooleanValue($value): ?int
    {
        if ($value === '' || $value === null) {
            return null;
        }
        return (int)$value;
    }

    /**
     * Normaliza string vacío a NULL
     */
    private function normalizeString($value): ?string
    {
        return $value === '' ? null : $value;
    }

    public function updateFichaKinesiologica()
    {
        $this->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'obra_social_id' => 'nullable|integer|exists:obra_socials,id',

            'diagnostico' => 'nullable|string|max:65535',
            'motivo_consulta' => 'nullable|string|max:65535',
            'posturas_dolorosas' => 'nullable|string|max:65535',
            'tipo_actividad' => 'nullable|string|max:255',
            'antecedentes_enfermedades' => 'nullable|string|max:65535',
            'antecedentes_familiares' => 'nullable|string|max:65535',
            'cirugias' => 'nullable|string|max:65535',
            'traumatismos_accidentes' => 'nullable|string|max:65535',
            'tratamientos_previos' => 'nullable|string|max:65535',
            'estado_salud_general' => 'nullable|string|max:255',
            'medicacion_actual' => 'nullable|string|max:65535',
            'observaciones_generales_anamnesis' => 'nullable|string|max:65535',

            'alteracion_peso' => 'nullable|in:0,1',
            'realiza_actividad_fisica' => 'nullable|in:0,1',
            'menarca' => 'nullable|in:0,1',
            'menopausia' => 'nullable|in:0,1',

            'partos' => 'nullable|integer|min:0',

            'visceral_palpacion' => 'nullable|string|max:255',
            'visceral_dermalgias' => 'nullable|string|max:255',
            'visceral_triggers' => 'nullable|string|max:255',
            'visceral_fijaciones' => 'nullable|string|max:255',
            'craneal_forma' => 'nullable|string|max:255',
            'craneal_triggers' => 'nullable|string|max:255',
            'craneal_fijaciones' => 'nullable|string|max:255',
            'craneal_musculos' => 'nullable|string|max:255',

            'tension_arterial' => 'nullable|string|max:50',
            'pulsos' => 'nullable|string|max:50',
            'auscultacion' => 'nullable|string|max:255',
            'ecg' => 'nullable|string|max:255',
            'ecodoppler' => 'nullable|string|max:255',
        ]);

        // Normalización
        $alteracionPeso = $this->normalizeBooleanValue($this->alteracion_peso);
        $realizaActividad = $this->normalizeBooleanValue($this->realiza_actividad_fisica);
        $menarca = $this->normalizeBooleanValue($this->menarca);
        $menopausia = $this->normalizeBooleanValue($this->menopausia);

        $this->ficha->update([
            'doctor_id' => $this->doctor_id,
            'obra_social_id' => $this->obra_social_id,

            'diagnostico' => $this->normalizeString($this->diagnostico),
            'motivo_consulta' => $this->normalizeString($this->motivo_consulta),
            'posturas_dolorosas' => $this->normalizeString($this->posturas_dolorosas),
            'realiza_actividad_fisica' => $realizaActividad,
            'tipo_actividad' => $this->normalizeString($this->tipo_actividad),
            'antecedentes_enfermedades' => $this->normalizeString($this->antecedentes_enfermedades),
            'antecedentes_familiares' => $this->normalizeString($this->antecedentes_familiares),
            'cirugias' => $this->normalizeString($this->cirugias),
            'traumatismos_accidentes' => $this->normalizeString($this->traumatismos_accidentes),
            'tratamientos_previos' => $this->normalizeString($this->tratamientos_previos),
            'estado_salud_general' => $this->normalizeString($this->estado_salud_general),

            'alteracion_peso' => $alteracionPeso,
            'medicacion_actual' => $this->normalizeString($this->medicacion_actual),
            'observaciones_generales_anamnesis' => $this->normalizeString($this->observaciones_generales_anamnesis),

            'menarca' => $menarca,
            'menopausia' => $menopausia,
            'partos' => $this->partos,

            'visceral_palpacion' => $this->normalizeString($this->visceral_palpacion),
            'visceral_dermalgias' => $this->normalizeString($this->visceral_dermalgias),
            'visceral_triggers' => $this->normalizeString($this->visceral_triggers),
            'visceral_fijaciones' => $this->normalizeString($this->visceral_fijaciones),
            'craneal_forma' => $this->normalizeString($this->craneal_forma),
            'craneal_triggers' => $this->normalizeString($this->craneal_triggers),
            'craneal_fijaciones' => $this->normalizeString($this->craneal_fijaciones),
            'craneal_musculos' => $this->normalizeString($this->craneal_musculos),
            'tension_arterial' => $this->normalizeString($this->tension_arterial),
            'pulsos' => $this->normalizeString($this->pulsos),
            'auscultacion' => $this->normalizeString($this->auscultacion),
            'ecg' => $this->normalizeString($this->ecg),
            'ecodoppler' => $this->normalizeString($this->ecodoppler),
        ]);

        if (function_exists('audit_log')) {
            audit_log('ficha.kinesiologia.actualizacion', $this->ficha, "Edicion de la Ficha Kinesiológica");
        }

        $this->dispatch('swal', [
            'title' => 'Ficha actualizada correctamente',
            'icon' => 'success'
        ]);

        return redirect()->route('kinesiologia.ficha-kinesiologica-index', [
            'paciente' => $this->ficha->paciente_id
        ]);
    }

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
            ->layout('layouts.app');
    }
}
