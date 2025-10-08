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

    public $name, $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo;
    public $tipolicencia_id, $disase_id, $paciente_enfermedades, $patient, $disase, $archivo, $enfermedade;

    public $modal = false;

    // Propiedades del formulario de atención/historial (Pivot Data)
    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad, $horas_reposo;

    // Propiedades para la subida de archivos (serán objetos TemporaryUploadedFile)
    public $pdf_enfermedad;
    public $imgen_enfermedad;

    public $medicacion, $dosis, $detalle_medicacion, $nro_osef, $tipodelicencia, $enfermedade_id, $art, $motivo_consulta;
    public $estado_enfermedad, $derivacion_psiquiatrica;

    public $pickerOpen = false;

    protected $rules = [
        'enfermedade_id' => 'nullable|exists:enfermedades,id',
        'name' => 'required_without:enfermedade_id|string|min:2',
        'detalle_diagnostico' => 'nullable|string',
        'fecha_atencion_enfermedad' => 'nullable|date',
        // Validar que la fecha finalización sea igual o posterior a la de atención
        'fecha_finalizacion_enfermedad' => 'nullable|date|after_or_equal:fecha_atencion_enfermedad',
        'horas_reposo' => 'nullable|integer|min:0',

        // Reglas para la subida de archivos
        'pdf_enfermedad' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        'imgen_enfermedad' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:8192', // 8MB

        'medicacion' => 'nullable|string',
        'dosis' => 'nullable|string',
        'motivo_consulta' => 'nullable|string',
        'derivacion_psiquiatrica' => 'nullable|boolean', // Asumiendo que es un checkbox/boolean
        'estado_enfermedad' => 'nullable|boolean', // Asumiendo que es un checkbox/boolean
        'art' => 'nullable|string',
        'detalle_medicacion' => 'nullable|string',
        'nro_osef' => 'nullable|string',
        'tipodelicencia' => 'nullable|string',
    ];

    /**
     * @param Paciente $paciente Inyección del modelo Paciente
     */
    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->paciente_enfermedades = $paciente->enfermedades;

        Log::info('📋 Componente montado PatientEnfermedade', [
            'paciente_id' => $paciente->id,
            'total_enfermedades' => $this->paciente_enfermedades->count(),
        ]);

        // Inicializar booleanos a 0 para consistencia si no hay valor
        $this->estado_enfermedad = 0;
        $this->derivacion_psiquiatrica = 0;
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
        if (!$enfermedade) {
            $this->dispatch('toast', type: 'error', message: 'Enfermedad no encontrada.');
            return;
        }

        // Resetear solo las propiedades del formulario antes de abrir el modal
        $this->reset([
            'detalle_diagnostico',
            'fecha_atencion_enfermedad',
            'fecha_finalizacion_enfermedad',
            'horas_reposo',
            'pdf_enfermedad',
            'imgen_enfermedad',
            'medicacion',
            'dosis',
            'detalle_medicacion',
            'nro_osef',
            'tipodelicencia',
            'art',
            'motivo_consulta',
            'estado_enfermedad',
            'derivacion_psiquiatrica'
        ]);

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

            // 1️⃣ Resolver enfermedad (Crear si no existe o usar ID existente)
            if (empty($this->enfermedade_id)) {
                $nombre = mb_strtolower(trim($this->name ?? $this->search ?? ''));
                if (empty($nombre)) {
                    throw new \Exception("Debe ingresar el nombre de la enfermedad o seleccionarlo.");
                }

                $enfermedad = Enfermedade::firstOrCreate(
                    ['name' => $nombre],
                    ['slug' => Str::slug($nombre), 'codigo' => '']
                );
                $enfermedadeId = $enfermedad->id;
            } else {
                $enfermedadeId = $this->enfermedade_id;
            }

            // 2️⃣ Archivos (Guardar con nombre único)
            $dir = "archivos_enfermedades/paciente_{$this->patient->id}";
            Storage::disk('public')->makeDirectory($dir);

            $archivoPathEnfermedad = null;
            if (isset($data['imgen_enfermedad']) && $data['imgen_enfermedad'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $extension = $data['imgen_enfermedad']->getClientOriginalExtension();
                $nombreArchivoUnico = Str::random(20) . '.' . $extension;
                $archivoPathEnfermedad = $data['imgen_enfermedad']->storeAs($dir, $nombreArchivoUnico, 'public');
            }

            $archivoPathPDF = null;
            if (isset($data['pdf_enfermedad']) && $data['pdf_enfermedad'] instanceof \Livewire\Features\SupportFileUploads\TemporaryUploadedFile) {
                $extensionDorso = $data['pdf_enfermedad']->getClientOriginalExtension();
                $nombreArchivoUnicoDorso = Str::random(20) . '.' . $extensionDorso;
                $archivoPathPDF = $data['pdf_enfermedad']->storeAs($dir, $nombreArchivoUnicoDorso, 'public');
            }

            // 3️⃣ Datos del registro (Pivot Data)
            $pivotData = [
                'fecha_atencion_enfermedad' => $data['fecha_atencion_enfermedad'] ?? null,
                'detalle_diagnostico' => $data['detalle_diagnostico'] ?? null,
                'imgen_enfermedad' => $archivoPathEnfermedad, // Usando ruta con nombre único
                'pdf_enfermedad' => $archivoPathPDF, // Usando ruta con nombre único
                'fecha_finalizacion_enfermedad' => $data['fecha_finalizacion_enfermedad'] ?? null,
                'horas_reposo' => $data['horas_reposo'] ?? null,
                'medicacion' => $data['medicacion'] ?? null,
                'dosis' => $data['dosis'] ?? null,
                'motivo_consulta' => $data['motivo_consulta'] ?? null,
                'derivacion_psiquiatrica' => $data['derivacion_psiquiatrica'] ?? 0,
                'estado_enfermedad' => $data['estado_enfermedad'] ?? 0,
                'detalle_medicacion' => $data['detalle_medicacion'] ?? null,
                'nro_osef' => $data['nro_osef'] ?? null,
                'tipodelicencia' => $data['tipodelicencia'] ?? null,
                'art' => $data['art'] ?? null,
            ];

            // 4️⃣ Adjuntar la enfermedad (creando un nuevo registro de historial)
            // Ya no necesitas verificar si ya existe. Cada llamada attach es un nuevo registro/atención.
            $this->patient->enfermedades()->attach($enfermedadeId, $pivotData);

            Log::info('💾 Atención médica registrada correctamente', [
                'paciente_id' => $this->patient->id,
                'enfermedade_id' => $enfermedadeId,
            ]);

            $this->modal = false;
            $this->pickerOpen = false;

            // 5️⃣ Resetear todas las propiedades del formulario
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

            // Actualizar la lista de enfermedades del paciente para refrescar la vista
            $this->paciente_enfermedades = $this->patient->enfermedades()->get();
            $this->resetValidation();

            session()->flash('success', 'Atención médica agregada correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('⚠️ Error de validación al agregar atención médica', $e->errors());
            throw $e; // Re-lanza la excepción para que Livewire la maneje
        } catch (\Exception $e) {
            Log::error('❌ Error al agregar atención médica', [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ]);
            session()->flash('error', 'Ocurrió un error al agregar la atención médica: ' . $e->getMessage());
        }
    }

    public function addNew()
    {
        Log::info('➕ Creando nueva enfermedad base');
        $nombre = mb_strtolower(trim($this->search));

        if (empty($nombre)) {
            session()->flash('error', 'Debe ingresar un nombre para la nueva enfermedad.');
            return;
        }

        $newDisase = Enfermedade::firstOrCreate(
            ['name' => $nombre],
            ['slug' => Str::slug($nombre), 'codigo' => '']
        );

        $this->enfermedade = $newDisase;
        $this->name = $newDisase->name;
        $this->addModalDisase($newDisase->id);
    }

    public function render()
    {
        $tipolicencias = Tipolicencia::all();

        // Asegurar que la búsqueda se haga solo si hay texto y no si ya se seleccionó un ID
        $enfermedades = ($this->search && !$this->enfermedade_id)
            ? Enfermedade::where('name', 'like', '%' . $this->search . '%')
            ->orWhere('codigo', 'like', '%' . $this->search . '%')
            ->take(10)
            ->get()
            : collect();

        return view('livewire.patient.patient-enfermedade', [
            'enfermedades' => $enfermedades,
            'tipolicencias' => $tipolicencias
        ]);
    }
}
