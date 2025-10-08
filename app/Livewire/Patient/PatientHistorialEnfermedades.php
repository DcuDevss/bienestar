<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Disase;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Livewire\WithPagination;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PatientHistorialEnfermedades extends Component
{
    use WithPagination;
    use WithFileUploads;

    #[Url]
    public $search = '';
    public $perPage = 4;

    public $sortAsc = true;
    public $sortField = 'name';

    public $enfermedadeId;
    public $name, $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo, $tipolicencia_id,
        $enfermedade_id, $paciente_enfermedades, $patient, $enfermedade, $archivo, $art;

    public $modal = false;

    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad, $horas_reposo, $pdf_enfermedad,
        $imgen_enfermedad, $medicacion, $dosis, $detalle_medicacion, $nro_osef, $tipodelicencia, $pacienteId, $patient_disases;

    // --- Autocomplete dentro del modal ---
    public $nameSearch = '';
    public $namePickerOpen = false;
    public $nameOptions = [];
    public $nameIndex = 0;

    public $pivotId = null;
    public $original_enfermedade_id = null;

    protected $rules = [
        'enfermedade_id' => 'nullable',
        'name' => 'nullable',
        'detalle_diagnostico' => 'nullable',
        'fecha_atencion_enfermedad' => 'nullable',
        'fecha_finalizacion_enfermedad' => 'nullable',
        'horas_reposo' => 'nullable',
        'pdf_enfermedad' => 'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad' => 'nullable|file',
        'medicacion' => 'nullable',
        'dosis' => 'nullable',
        'detalle_medicacion' => 'nullable',
        'nro_osef' => 'nullable',
        'art' => 'nullable',
        'tipodelicencia' => 'nullable',
    ];

    public function mount($paciente)
    {
        Log::info("🩺 Montando componente PatientHistorialEnfermedades", ['pacienteId' => $paciente]);
        $this->pacienteId = $paciente;
    }

    /** Abre el modal con los datos de la enfermedad */
    public function editModalDisase($enfermedadeId)
    {
        Log::info("➡ Entró a editModalDisase", [
            'pacienteId' => $this->pacienteId,
            'enfermedadeId' => $enfermedadeId
        ]);

        try {
            $paciente = Paciente::with(['enfermedades' => function ($query) use ($enfermedadeId) {
                $query->where('enfermedades.id', $enfermedadeId);
            }])->find($this->pacienteId);

            if (!$paciente) {
                Log::error("❌ No se encontró paciente", ['pacienteId' => $this->pacienteId]);
                return;
            }

            if ($paciente->enfermedades->isEmpty()) {
                Log::warning("⚠ El paciente no tiene enfermedades con ese ID", [
                    'pacienteId' => $this->pacienteId,
                    'enfermedadeId' => $enfermedadeId
                ]);
                return;
            }

            $enf = $paciente->enfermedades->first();
            Log::info("✅ Enfermedad encontrada", [
                'enfermedadeId' => $enf->id,
                'nombre' => $enf->name,
                'pivot' => $enf->pivot?->toArray()
            ]);

            // Seteamos datos del modal
            $this->name  = $enf->name;
            $this->enfermedade_id = $enf->id;
            $this->original_enfermedade_id = $enf->id;
            $this->pivotId = $enf->pivot->id ?? null;

            $this->fecha_atencion_enfermedad     = $enf->pivot->fecha_atencion_enfermedad ?? null;
            $this->detalle_medicacion            = $enf->pivot->detalle_medicacion ?? null;
            $this->fecha_finalizacion_enfermedad = $enf->pivot->fecha_finalizacion_enfermedad ?? null;
            $this->horas_reposo                  = $enf->pivot->horas_reposo ?? null;
            $this->medicacion                    = $enf->pivot->medicacion ?? null;
            $this->dosis                         = $enf->pivot->dosis ?? null;
            $this->nro_osef                      = $enf->pivot->nro_osef ?? null;
            $this->art                           = $enf->pivot->art ?? null;
            $this->detalle_diagnostico           = $enf->pivot->detalle_diagnostico ?? null;
            $this->tipodelicencia                = $enf->pivot->tipodelicencia ?? null;

            $this->modal = true;
            $this->nameSearch = '';
            $this->namePickerOpen = false;
            $this->nameOptions = [];

            $this->openNamePicker();
        } catch (\Exception $e) {
            Log::error("💥 Error en editModalDisase", ['exception' => $e->getMessage()]);
        }
    }

    /** Guardar cambios */
    public function editDisase()
    {
        Log::info("📝 Iniciando editDisase", [
            'pacienteId' => $this->pacienteId,
            'enfermedade_id' => $this->enfermedade_id,
            'original_enfermedade_id' => $this->original_enfermedade_id
        ]);

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
            Storage::disk('public')->makeDirectory($dir);

            // Imagen
            if (isset($data['imgen_enfermedad'])) {
                $archivoPath = $data['imgen_enfermedad']->storeAs($dir, $data['imgen_enfermedad']->getClientOriginalName());
                Log::info("🖼 Imagen guardada", ['path' => $archivoPath]);
            } else {
                $archivoPath = $paciente->enfermedades()->find($this->original_enfermedade_id)?->pivot->imgen_enfermedad;
            }

            // PDF
            if (isset($data['pdf_enfermedad'])) {
                $archivoPathDorso = $data['pdf_enfermedad']->storeAs($dir, $data['pdf_enfermedad']->getClientOriginalName());
                Log::info("📄 PDF guardado", ['path' => $archivoPathDorso]);
            } else {
                $archivoPathDorso = $paciente->enfermedades()->find($this->original_enfermedade_id)?->pivot->pdf_enfermedad;
            }

            $pivotData = [
                'fecha_atencion_enfermedad'     => $data['fecha_atencion_enfermedad'],
                'detalle_medicacion'            => $data['detalle_medicacion'],
                'detalle_diagnostico'           => $data['detalle_diagnostico'],
                'imgen_enfermedad'              => $archivoPath,
                'pdf_enfermedad'                => $archivoPathDorso,
                'fecha_finalizacion_enfermedad' => $data['fecha_finalizacion_enfermedad'],
                'horas_reposo'                  => $data['horas_reposo'],
                'nro_osef'                      => $data['nro_osef'],
                'art'                           => $data['art'],
                'medicacion'                    => $data['medicacion'],
                'dosis'                         => $data['dosis'],
                'tipodelicencia'                => $data['tipodelicencia'],
            ];

            Log::debug("📎 Datos del pivot a guardar", $pivotData);

            $changedDisease = ($enfermedadeId != $this->original_enfermedade_id);
            if ($changedDisease) {
                Log::info("🔄 Cambió la enfermedad asociada, haciendo detach + attach", [
                    'old' => $this->original_enfermedade_id,
                    'new' => $enfermedadeId
                ]);
                $paciente->enfermedades()->detach($this->original_enfermedade_id);
                $paciente->enfermedades()->attach($enfermedadeId, $pivotData);
            } else {
                $enfermedade = $paciente->enfermedades()->findOrFail($enfermedadeId);
                $enfermedade->update([
                    'name' => $this->name,
                    'slug' => Str::slug($this->name),
                ]);
                $paciente->enfermedades()->updateExistingPivot($enfermedadeId, $pivotData);
                Log::info("💾 Actualizado pivot existente", ['enfermedadeId' => $enfermedadeId]);
            }

            $this->modal = false;
            $this->dispatch('toast', type: 'success', message: 'Enfermedad editada correctamente');
            Log::info("✅ Enfermedad editada correctamente");

            $this->reset([
                'name',
                'fecha_atencion_enfermedad',
                'detalle_diagnostico',
                'detalle_medicacion',
                'fecha_finalizacion_enfermedad',
                'horas_reposo',
                'medicacion',
                'nro_osef',
                'tipolicencia_id',
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
            ]);

            $this->patient_disases = $paciente->enfermedades()->get();
            $this->resetValidation();
        } catch (\Exception $e) {
            Log::error("💥 Error en editDisase", [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile()
            ]);
        }
    }

    // =============================================================
    public function render()
    {
        Log::debug("🎨 Renderizando componente", ['search' => $this->search]);

        $paciente = Paciente::find($this->pacienteId);

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
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            Log::debug("🧾 Enfermedades obtenidas", ['total' => $enfermedades->total()]);

            return view('livewire.patient.patient-historial-enfermedades', [
                'paciente'     => $paciente,
                'enfermedades' => $enfermedades,
            ])->layout('layouts.app');
        }

        Log::warning("⚠ No se encontró paciente al renderizar", ['pacienteId' => $this->pacienteId]);
        return view('livewire.patient.patient-historial-enfermedades')->layout('layouts.app');
    }
}
