<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

class PatientHistorialEnfermedades extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Url]
    public $search = '';
    public $perPage = 4;

    public $sortAsc = true;
    public $sortField = 'name';

    // Propiedades del formulario
    public $enfermedadeId;
    public $name, $art;
    public $modal = false;

    // 👇 PROPIEDADES PARA ARCHIVOS SUBIDOS (Livewire/TemporaryUploadedFile)
    public $imgen_enfermedad;
    public $pdf_enfermedad;

    // 👇 PROPIEDADES PARA ARCHIVOS EXISTENTES (string path)
    public $current_imgen_enfermedad_path = null;
    public $current_pdf_enfermedad_path = null;

    // Propiedades del Pivot (Historial)
    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad, $horas_reposo,
        $medicacion, $dosis, $detalle_medicacion, $nro_osef, $tipodelicencia, $motivo_consulta;

    // IDs de control
    public $pacienteId;
    public $pivotId = null;
    public $original_enfermedade_id = null;

    // Otras propiedades de clase
    public $patient, $patient_disases;

    // --- Autocomplete dentro del modal ---
    public $nameSearch = '';
    public $namePickerOpen = false;
    public $nameOptions = [];
    public $nameIndex = 0;
    public $enfermedade_id;


    protected $rules = [
        'enfermedade_id' => 'nullable',
        'name' => 'nullable',
        'detalle_diagnostico' => 'nullable',
        'fecha_atencion_enfermedad' => 'nullable',
        'fecha_finalizacion_enfermedad' => 'nullable',
        'horas_reposo' => 'nullable',
        'pdf_enfermedad' => 'nullable|file|mimes:pdf|max:10240', // Corregido: solo pdf
        'imgen_enfermedad' => 'nullable|file|mimes:png,jpg,jpeg,gif|max:10240', // Corregido: solo img
        'medicacion' => 'nullable',
        'dosis' => 'nullable',
        'detalle_medicacion' => 'nullable',
        'nro_osef' => 'nullable',
        'art' => 'nullable',
        'tipodelicencia' => 'nullable',
        'motivo_consulta' => 'nullable',
    ];

    public function mount($paciente)
    {
        Log::info("🩺 Montando componente PatientHistorialEnfermedades", ['pacienteId' => $paciente]);
        $this->pacienteId = $paciente;
    }

    public function closeNamePicker()
    {
        $this->namePickerOpen = false;
        $this->nameOptions = [];
        Log::info('✅ NamePicker cerrado');
    }

    /** Abre el modal con los datos del registro de historial. */
    public function editModalDisase($pacienteId, $enfermedadeId, $pivotId)
    {
        Log::info('➡ Entró a editModalDisase', compact('pacienteId', 'enfermedadeId', 'pivotId'));

        $this->patient = Paciente::findOrFail($pacienteId);

        $enfermedadPivot = $this->patient->enfermedades()
            ->where('enfermedades.id', $enfermedadeId)
            ->wherePivot('id', $pivotId)
            ->first();

        if ($enfermedadPivot) {
            $enf = $enfermedadPivot;

            Log::info('✅ Enfermedad encontrada con datos pivot', [
                'enfermedadeId' => $enf->id,
                'nombre' => $enf->name,
                'pivot' => $enf->pivot?->toArray(),
            ]);

            $this->name = ucfirst($enf->name);
            $this->enfermedade_id = $enf->id;
            $this->original_enfermedade_id = $enf->id;
            $this->pivotId = $pivotId;

            $this->detalle_diagnostico = $enf->pivot->detalle_diagnostico ?? null;
            $this->fecha_atencion_enfermedad = $enf->pivot->fecha_atencion_enfermedad ?? null;
            $this->fecha_finalizacion_enfermedad = $enf->pivot->fecha_finalizacion_enfermedad ?? null;
            $this->horas_reposo = $enf->pivot->horas_reposo ?? null;
            $this->medicacion = $enf->pivot->medicacion ?? null;
            $this->dosis = $enf->pivot->dosis ?? null;
            $this->tipodelicencia = $enf->pivot->tipodelicencia ?? null;
            $this->motivo_consulta = $enf->pivot->motivo_consulta ?? null;
            $this->art = $enf->pivot->art ?? null;
            $this->nro_osef = $enf->pivot->nro_osef ?? null;

            // 1. Resetear inputs de Livewire (importante)
            $this->imgen_enfermedad = null;
            $this->pdf_enfermedad = null;

            // 2. Cargar paths existentes para visualización en el modal
            $this->current_imgen_enfermedad_path = $enf->pivot->imgen_enfermedad;
            $this->current_pdf_enfermedad_path = $enf->pivot->pdf_enfermedad;

            $this->modal = true;
            $this->nameSearch = $this->name;
            $this->namePickerOpen = false;
        } else {
            Log::warning('⚠️ El registro de historial no existe.', compact('pacienteId', 'enfermedadeId', 'pivotId'));
        }
    }


    /** Guardar cambios */
    public function editDisase()
    {
        Log::info("📝 Iniciando editDisase", [
            'pacienteId' => $this->pacienteId,
            'enfermedade_id' => $this->enfermedade_id,
            'original_enfermedade_id' => $this->original_enfermedade_id,
            'pivotId' => $this->pivotId
        ]);

        if (!$this->pivotId) {
            $this->dispatch('toast', type: 'error', message: 'Error: No se encontró el ID de historial para editar.');
            Log::error("❌ No se encontró pivotId para editar.");
            return;
        }

        try {
            $data = $this->validate();
            Log::debug("📋 Datos validados", $data);

            $paciente = Paciente::find($this->pacienteId);
            if (!$paciente) {
                Log::error("❌ Paciente no encontrado al intentar editar enfermedad", ['pacienteId' => $this->pacienteId]);
                return;
            }

            $enfermedadeId = $this->enfermedade_id ?? $this->original_enfermedade_id;
            $dir = "archivos_enfermedades/paciente_{$paciente->id}";

            // 1. Inicializar las rutas con los paths existentes
            $archivoPath = $this->current_imgen_enfermedad_path;
            $archivoPathDorso = $this->current_pdf_enfermedad_path;

            // 2. Imagen (solo subir si es un nuevo archivo)
            if ($this->imgen_enfermedad) {
                // Eliminar archivo viejo si existe
                if ($this->current_imgen_enfermedad_path && Storage::disk('public')->exists($this->current_imgen_enfermedad_path)) {
                    Storage::disk('public')->delete($this->current_imgen_enfermedad_path);
                    Log::info("🗑️ Imagen anterior eliminada", ['path' => $this->current_imgen_enfermedad_path]);
                }
                // Guardar el nuevo archivo
                $archivoPath = $this->imgen_enfermedad->store($dir, 'public');
                Log::info("🖼 Imagen guardada", ['path' => $archivoPath]);
            }

            // 3. PDF (solo subir si es un nuevo archivo)
            if ($this->pdf_enfermedad) {
                // Eliminar archivo viejo si existe
                if ($this->current_pdf_enfermedad_path && Storage::disk('public')->exists($this->current_pdf_enfermedad_path)) {
                    Storage::disk('public')->delete($this->current_pdf_enfermedad_path);
                    Log::info("🗑️ PDF anterior eliminado", ['path' => $this->current_pdf_enfermedad_path]);
                }
                // Guardar el nuevo archivo
                $archivoPathDorso = $this->pdf_enfermedad->store($dir, 'public');
                Log::info("📄 PDF guardado", ['path' => $archivoPathDorso]);
            }

            $pivotData = [
                'fecha_atencion_enfermedad'     => $data['fecha_atencion_enfermedad'],
                'detalle_medicacion'             => $data['detalle_medicacion'],
                'detalle_diagnostico'             => $data['detalle_diagnostico'],
                'imgen_enfermedad'                 => $archivoPath, // Nueva ruta o la existente
                'pdf_enfermedad'                 => $archivoPathDorso, // Nueva ruta o la existente
                'fecha_finalizacion_enfermedad' => $data['fecha_finalizacion_enfermedad'],
                'horas_reposo'                     => $data['horas_reposo'],
                'nro_osef'                         => $data['nro_osef'],
                'art'                             => $data['art'],
                'medicacion'                     => $data['medicacion'],
                'dosis'                         => $data['dosis'],
                'tipodelicencia'                 => $data['tipodelicencia'],
                'motivo_consulta'                 => $this->motivo_consulta,
                'enfermedade_id'                 => $enfermedadeId,
            ];

            Log::debug("📎 Datos del pivot a guardar", $pivotData);

            // Actualizar directamente la fila del historial por su ID
            DB::table('enfermedade_paciente')->where('id', $this->pivotId)->update($pivotData);
            Log::info("💾 Actualizado registro de historial específico por pivotId", ['pivotId' => $this->pivotId]);

            // Actualizar el nombre de la enfermedad si fue modificado (opcional, basado en tu lógica)
            $enfermedad = Enfermedade::find($enfermedadeId);
            if ($enfermedad && $enfermedad->name !== $this->name) {
                $enfermedad->update([
                    'name' => $this->name,
                    'slug' => Str::slug($this->name),
                ]);
            }

            $this->modal = false;
            $this->dispatch('toast', type: 'success', message: 'Enfermedad editada correctamente');
            Log::info("✅ Enfermedad editada correctamente");

            // 4. Resetear propiedades, incluyendo los current_path
            $this->reset([
                'name',
                'fecha_atencion_enfermedad',
                'detalle_diagnostico',
                'detalle_medicacion',
                'fecha_finalizacion_enfermedad',
                'horas_reposo',
                'medicacion',
                'nro_osef',
                'tipodelicencia',
                'art',
                'dosis',
                'imgen_enfermedad',
                'pdf_enfermedad',
                'search',
                'nameSearch',
                'namePickerOpen',
                'nameOptions',
                'nameIndex',
                'pivotId',
                'original_enfermedade_id',
                'current_imgen_enfermedad_path',
                'current_pdf_enfermedad_path', // Limpiar paths
            ]);

            $this->patient_disases = $paciente->enfermedades()->get();
            $this->resetValidation();
        } catch (\Exception $e) {
            Log::error("💥 Error en editDisase", [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile()
            ]);
            $this->dispatch('toast', type: 'error', message: 'Error al intentar editar la enfermedad. Revisa los logs.');
        }
    }

    // ... resto del componente (render, etc.) ...

    public function render()
    {
        Log::debug("🎨 Renderizando componente", ['search' => $this->search]);

        $paciente = Paciente::find($this->pacienteId);

        $enfermedades = new LengthAwarePaginator(
            [],
            0,
            $this->perPage,
            1,
            ['path' => \Illuminate\Pagination\Paginator::resolveCurrentPath()]
        );

        if ($paciente) {
            Log::debug("👤 Paciente encontrado para render", ['id' => $paciente->id]);
            $enfermedades = $paciente->enfermedades()
                ->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.detalle_diagnostico', 'like', '%' . $this->search . '%')
                        ->orWhere('enfermedade_paciente.detalle_medicacion', 'like', '%' . $this->search . '%');
                })
                ->orderBy('enfermedade_paciente.id', $this->sortAsc ? 'desc' : 'asc')
                ->withPivot('id')
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            Log::debug("🧾 Enfermedades obtenidas", ['total' => $enfermedades->total()]);
        } else {
            Log::warning("⚠ No se encontró paciente al renderizar", ['pacienteId' => $this->pacienteId]);
        }

        return view('livewire.patient.patient-historial-enfermedades', [
            'paciente'        => $paciente,
            'enfermedades' => $enfermedades,
        ])->layout('layouts.app');
    }
}
