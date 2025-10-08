<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PatientEnfermedade extends Component
{
    use WithFileUploads;

    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $disaseId;

    public $name, $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo, $tipolicencia_id,
        $disase_id, $paciente_enfermedades, $patient, $disase, $archivo, $enfermedade;

    public $modal = false;

    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad, $horas_reposo, $pdf_enfermedad,
        $imgen_enfermedad, $medicacion, $dosis, $detalle_medicacion, $nro_osef, $tipodelicencia, $enfermedade_id, $art, $motivo_consulta,
        $estado_enfermedad, $derivacion_psiquiatrica;

    public $pickerOpen = false;

    protected $rules = [
        'enfermedade_id'                => 'nullable|exists:enfermedades,id',
        'name'                          => 'required_without:enfermedade_id|string|min:2',
        'detalle_diagnostico'           => 'nullable',
        'fecha_atencion_enfermedad'     => 'nullable|date',
        'fecha_finalizacion_enfermedad' => 'nullable|date|after_or_equal:fecha_atencion_enfermedad',
        'horas_reposo'                  => 'nullable|integer',
        'pdf_enfermedad'                => 'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad'              => 'nullable|file|mimes:png,jpg,jpeg,gif|max:8192',
        'medicacion'                    => 'nullable',
        'dosis'                         => 'nullable',
        'motivo_consulta'               => 'nullable',
        'derivacion_psiquiatrica'       => 'nullable',
        'estado_enfermedad'             => 'nullable|boolean',
        'art'                           => 'nullable',
        'detalle_medicacion'            => 'nullable',
        'nro_osef'                      => 'nullable',
        'tipodelicencia'                => 'nullable',
    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->paciente_enfermedades = $paciente->enfermedades;

        Log::info('📋 Componente montado PatientEnfermedade', [
            'paciente_id' => $paciente->id,
            'total_enfermedades' => $this->paciente_enfermedades->count(),
        ]);
    }

    public function openPicker()
    {
        $this->pickerOpen = true;
    }
    public function closePicker()
    {
        $this->pickerOpen = false;
    }

    public function updatedSearch($value)
    {
        Log::debug('🔄 updatedSearch()', ['valor' => $value]);
        $this->enfermedade_id = null;
        $this->name = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function updatedName($value)
    {
        Log::debug('🔄 updatedName()', ['valor' => $value]);
        $this->enfermedade_id = null;
        $this->search = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function pickEnfermedad($id)
    {
        Log::debug('🩻 Enfermedad seleccionada', ['id' => $id]);
        if ($e = Enfermedade::find($id)) {
            $this->enfermedade_id = $e->id;
            $this->name           = $e->name;
            $this->search         = $e->name;
            $this->pickerOpen     = false;
        }
    }

    public function addModalDisase($enfermedadeId)
    {
        Log::info('🩺 Abriendo modal enfermedad', ['enfermedade_id' => $enfermedadeId]);
        $enfermedade = Enfermedade::find($enfermedadeId);
        $this->name = $enfermedade->name;
        $this->enfermedade_id = $enfermedade->id;
        $this->search = $enfermedade->name;
        $this->pickerOpen = false;
        $this->modal = true;
    }

    public function addDisase()
    {
        Log::info('🧾 Iniciando registro de atención médica');
        try {
            $data = $this->validate();
            Log::debug('📋 Datos validados correctamente', $data);

            // 1️⃣ Resolver enfermedad
            if (empty($data['enfermedade_id'])) {
                $nombre = mb_strtolower(trim($this->name ?? $this->search ?? ''));
                $enfermedad = Enfermedade::firstOrCreate(
                    ['name' => $nombre],
                    ['slug' => Str::slug($nombre), 'codigo' => '']
                );
                $enfermedadeId = $enfermedad->id;
            } else {
                $enfermedadeId = $data['enfermedade_id'];
            }

            // 2️⃣ Archivos
            $dir = "archivos_enfermedades/paciente_{$this->patient->id}";
            Storage::disk('public')->makeDirectory($dir);
            $archivoPathEnfermedad = $data['imgen_enfermedad']?->storeAs($dir, $data['imgen_enfermedad']->getClientOriginalName(), 'public');
            $archivoPathPDF = $data['pdf_enfermedad']?->storeAs($dir, $data['pdf_enfermedad']->getClientOriginalName(), 'public');

            // 3️⃣ Verificar si ya existe el mismo tipo de enfermedad
            $yaExiste = $this->patient->enfermedades()
                ->wherePivot('enfermedade_id', $enfermedadeId)
                ->exists();

            $pivotData = [
                'fecha_atencion_enfermedad'      => $data['fecha_atencion_enfermedad'] ?? null,
                'detalle_diagnostico'            => $data['detalle_diagnostico'] ?? null,
                'imgen_enfermedad'               => $archivoPathEnfermedad,
                'pdf_enfermedad'                 => $archivoPathPDF,
                'fecha_finalizacion_enfermedad'  => $data['fecha_finalizacion_enfermedad'] ?? null,
                'horas_reposo'                   => $data['horas_reposo'] ?? null,
                'medicacion'                     => $data['medicacion'] ?? null,
                'dosis'                          => $data['dosis'] ?? null,
                'motivo_consulta'                => $data['motivo_consulta'] ?? null,
                'derivacion_psiquiatrica'        => $data['derivacion_psiquiatrica'] ?? null,
                'estado_enfermedad'              => $data['estado_enfermedad'] ?? 0,
                'detalle_medicacion'             => $data['detalle_medicacion'] ?? null,
                'nro_osef'                       => $data['nro_osef'] ?? null,
                'tipodelicencia'                 => $data['tipodelicencia'] ?? null,
                'art'                            => $data['art'] ?? null,
            ];

            if ($yaExiste) {
                Log::info('⚠️ El paciente ya tiene esta enfermedad, creando un nuevo registro adicional');
                $this->patient->enfermedades()->attach($enfermedadeId, $pivotData);
            } else {
                Log::info('✅ Nueva enfermedad asociada al paciente');
                $this->patient->enfermedades()->attach($enfermedadeId, $pivotData);
            }

            Log::info('💾 Atención médica registrada correctamente', [
                'paciente_id' => $this->patient->id,
                'enfermedade_id' => $enfermedadeId,
            ]);

            $this->modal = false;
            $this->pickerOpen = false;
            $this->reset([
                'name',
                'detalle_diagnostico',
                'fecha_atencion_enfermedad',
                'fecha_finalizacion_enfermedad',
                'horas_reposo',
                'dosis',
                'tipolicencia_id',
                'tipodelicencia',
                'art',
                'motivo_consulta',
                'derivacion_psiquiatrica',
                'estado_enfermedad',
                'imgen_enfermedad',
                'medicacion',
                'detalle_medicacion',
                'pdf_enfermedad',
                'nro_osef',
                'search',
                'enfermedade_id'
            ]);

            $this->paciente_enfermedades = $this->patient->enfermedades()->get();
            $this->resetValidation();

            session()->flash('success', 'Atención médica agregada correctamente.');
        } catch (\Exception $e) {
            Log::error('❌ Error al agregar atención médica', [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ]);
            session()->flash('error', 'Ocurrió un error al agregar la atención médica.');
        }
    }

    public function addNew()
    {
        $newDisase = Enfermedade::create([
            'name' => mb_strtolower($this->search),
            'slug' => Str::slug($this->search),
            'codigo' => '',
        ]);
        $this->enfermedade = $newDisase;
        $this->name = $newDisase->name;
        $this->addModalDisase($newDisase->id);
    }

    public function render()
    {
        $tipolicencias = Tipolicencia::all();
        $enfermedades = $this->search
            ? Enfermedade::search($this->search)->take(10)->get()
            : collect();

        return view('livewire.patient.patient-enfermedade', [
            'enfermedades'  => $enfermedades,
            'tipolicencias' => $tipolicencias
        ]);
    }
}
