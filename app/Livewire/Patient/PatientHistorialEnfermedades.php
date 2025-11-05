<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Livewire\Attributes\Url;

use App\Models\Paciente;
use App\Models\Enfermedade;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Carbon\Carbon;

class PatientHistorialEnfermedades extends Component
{
    use WithPagination, WithFileUploads;

    #[Url] public $search = '';
    public $perPage = 4;
    public $sortAsc = true;
    public $sortField = 'name';

    // contexto
    public $pacienteId;

    // modal & selección
    public $modal = false;
    public $pivotId = null;                 // fila exacta del pivot a editar
    public $original_enfermedade_id = null; // respaldo por si cambian la enfermedad
    public $enfermedade_id = null;          // seleccionada en el modal
    public $name = null;                    // para mostrar nombre en el modal

    // campos pivot
    public $detalle_diagnostico,
           $fecha_atencion_enfermedad,
           $fecha_finalizacion_enfermedad,
           $horas_reposo,
           $pdf_enfermedad,
           $imgen_enfermedad,
           $medicacion,
           $dosis,
           $detalle_medicacion,
           $nro_osef,
           $tipodelicencia,
           $derivacion_psiquiatrica,
           $motivo_consulta,
           $art;

    // Autocomplete dentro del modal
    public $nameSearch = '';        // lo que escribe en "Nombre"
    public $namePickerOpen = false;
    public $nameOptions = [];
    public $nameIndex = 0;

    protected $rules = [
        'enfermedade_id'                => 'required|integer|exists:enfermedades,id',
        'name'                          => 'nullable|string|min:1',
        'detalle_diagnostico'           => 'required|string',
        'fecha_atencion_enfermedad'     => 'required', // si querés estricta: date
        'fecha_finalizacion_enfermedad' => 'required', // idem
        'horas_reposo'                  => 'nullable|integer',
        'pdf_enfermedad'                => 'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad'              => 'nullable|file|mimes:png,jpg,jpeg,gif|max:8192',
        'medicacion'                    => 'nullable|string',
        'dosis'                         => 'nullable|string',
        'derivacion_psiquiatrica'       => 'nullable|string',
        'motivo_consulta'               => 'required|string',
        'detalle_medicacion'            => 'nullable|string',
        'nro_osef'                      => 'nullable|string',
        'art'                           => 'nullable|string',
        'tipodelicencia'                => 'required|string',
    ];

    public function mount($paciente)
    {
        $this->pacienteId = $paciente;
    }

    /**
     * MODO LEGADO: abre por id de enfermedad (puede traer "la primera" relación).
     * Lo dejamos por compatibilidad, pero para editar un episodio puntual
     * usá SIEMPRE openEditByPivot($pivotId).
     */
    #[On('ui.open-edit')]
    public function onUiOpenEdit($payload = [])
    {
        // reusa la lógica de openEditByPivot
        $this->openEditByPivot($payload['pivotId'] ?? null);
    }
    #[On('ui.open-edit')]
    public function dbg($payload = []) {
        $this->dispatch('swal', title:'Evento', text: json_encode($payload), icon:'info');
    }

    public function addDisase()
    {
        // compat temporal: si algo dispara addDisase, redirigimos al flujo correcto
        return $this->editDisase();
    }

    public function editModalDisase($enfermedadeId)
    {
        Log::info("➡ editModalDisase (LEGACY) con enfermedad_id={$enfermedadeId}");

        $paciente = Paciente::with(['enfermedades' => fn($q) =>
            $q->where('enfermedades.id', $enfermedadeId)
        ])->find($this->pacienteId);

        if (!$paciente || $paciente->enfermedades->isEmpty()) {
            Log::warning("⚠ No se encontró enfermedad para el paciente", [
                'pacienteId' => $this->pacienteId,
                'enfermedadeId' => $enfermedadeId
            ]);
            $this->dispatch('swal', title:'Error', text:'No se encontró el registro.', icon:'error');
            return;
        }

        $rel = $paciente->enfermedades->first();
        $this->hydrateFromRelation($rel);
    }

    /**
     * 👉 MÉTODO RECOMENDADO: abre por id del PIVOT (edición exacta).
     */
    public function openEditByPivot(...$args)
    {
        $pivotId = $args[0] ?? null;

        if (empty($pivotId)) {
            $this->dispatch('swal', title:'Error', text:'No se recibió el ID del episodio (pivot).', icon:'error');
            return;
        }

        $this->pivotId = (int) $pivotId;

        // pivot directo (y validación de pertenencia al paciente)
        $pivot = DB::table('enfermedade_paciente')->where('id', $this->pivotId)->first();
        if (!$pivot) {
            $this->dispatch('swal', title:'Error', text:'No se encontró el registro a editar.', icon:'error');
            return;
        }
        if ((int) $pivot->paciente_id !== (int) $this->pacienteId) {
            $this->dispatch('swal', title:'Error', text:'El episodio no corresponde a este paciente.', icon:'error');
            return;
        }

        $rel = \App\Models\Enfermedade::find($pivot->enfermedade_id);
        if (!$rel) {
            $this->dispatch('swal', title:'Error', text:'No se encontró la enfermedad asociada.', icon:'error');
            return;
        }

        // finge relación para reusar tu hidratador
        $rel->setRelation('pivot', (object) [
            'id'                           => $pivot->id,
            'enfermedade_id'               => $pivot->enfermedade_id,
            'paciente_id'                  => $pivot->paciente_id,
            'fecha_atencion_enfermedad'    => $pivot->fecha_atencion_enfermedad,
            'fecha_finalizacion_enfermedad'=> $pivot->fecha_finalizacion_enfermedad,
            'detalle_diagnostico'          => $pivot->detalle_diagnostico,
            'detalle_medicacion'           => $pivot->detalle_medicacion,
            'horas_reposo'                 => $pivot->horas_reposo,
            'medicacion'                   => $pivot->medicacion,
            'dosis'                        => $pivot->dosis,
            'nro_osef'                     => $pivot->nro_osef,
            'art'                          => $pivot->art,
            'tipodelicencia'               => $pivot->tipodelicencia,
            'derivacion_psiquiatrica'      => $pivot->derivacion_psiquiatrica,
            'motivo_consulta'              => $pivot->motivo_consulta,
            'imgen_enfermedad'             => $pivot->imgen_enfermedad,
            'pdf_enfermedad'               => $pivot->pdf_enfermedad,
            'created_at'                   => $pivot->created_at ?? null,
            'updated_at'                   => $pivot->updated_at ?? null,
        ]);

        $this->hydrateFromRelation($rel);
    }



    /**
     * Carga todas las propiedades del modal a partir de la relación (Enfermedade con ->pivot)
     */
    private function hydrateFromRelation(Enfermedade $rel): void
    {
        $this->enfermedade_id          = $rel->id;
        $this->original_enfermedade_id = $rel->id;
        $this->name                    = $rel->name;

        $p = $rel->pivot;

        $this->fecha_atencion_enfermedad      = $p->fecha_atencion_enfermedad
            ? Carbon::parse($p->fecha_atencion_enfermedad)->format('Y-m-d\TH:i') : null;
        $this->fecha_finalizacion_enfermedad  = $p->fecha_finalizacion_enfermedad
            ? Carbon::parse($p->fecha_finalizacion_enfermedad)->format('Y-m-d\TH:i') : null;

        $this->detalle_diagnostico  = $p->detalle_diagnostico;
        $this->detalle_medicacion   = $p->detalle_medicacion;
        $this->horas_reposo         = $p->horas_reposo;
        $this->medicacion           = $p->medicacion;
        $this->dosis                = $p->dosis;
        $this->nro_osef             = $p->nro_osef;
        $this->art                  = $p->art;
        $this->tipodelicencia       = $p->tipodelicencia;
        $this->derivacion_psiquiatrica = $p->derivacion_psiquiatrica;
        $this->motivo_consulta      = $p->motivo_consulta;

        // preparar autocomplete (si lo usás)
        $this->nameSearch     = $this->name;
        $this->namePickerOpen = false;
        $this->nameOptions    = [];
        $this->nameIndex      = 0;

        $this->modal = true;
    }

    /**
     * Guarda cambios del modal sobre **la fila exacta del pivot**.
     * Si cambian la enfermedad, se actualiza el campo enfermade_id del pivot.
     * NO renombra la enfermedad global (evita tocar name/slug de tabla enfermedades).
     */
    public function editDisase()
    {
        // 1) Validación + guards
        $data = $this->validate();

        $paciente = Paciente::find($this->pacienteId);
        if (!$paciente) {
            $this->dispatch('swal', title:'Error', text:'Paciente no encontrado.', icon:'error');
            return;
        }

        if (empty($this->pivotId)) {
            $this->dispatch('swal', title:'Error', text:'Falta identificar el registro a editar.', icon:'error');
            return;
        }

        // 2) Traer la fila actual del pivot (y validar pertenencia)
        $pivotActual = DB::table('enfermedade_paciente')->where('id', $this->pivotId)->first();
        if (!$pivotActual || (int) $pivotActual->paciente_id !== (int) $this->pacienteId) {
            $this->dispatch('swal', title:'Error', text:'El episodio no corresponde a este paciente.', icon:'error');
            return;
        }

        // 3) Determinar la enfermedad a guardar (cambio o fallback)
        $enfermedadeId = $this->enfermedade_id
            ?: ($this->original_enfermedade_id ?: $pivotActual->enfermedade_id);

        // 4) Directorio y manejo de archivos
        $dir = "archivos_enfermedades/paciente_{$paciente->id}";
        Storage::disk('public')->makeDirectory($dir);

        // Imagen
        $archivoPathImg = $pivotActual->imgen_enfermedad;
        if (!empty($data['imgen_enfermedad'])) {
            if (!str_starts_with($data['imgen_enfermedad']->getMimeType(), 'image/')) {
                $this->addError('imgen_enfermedad', 'El archivo debe ser una imagen válida.');
                return;
            }
            if ($archivoPathImg && Storage::disk('public')->exists($archivoPathImg)) {
                Storage::disk('public')->delete($archivoPathImg);
            }
            $archivoPathImg = $data['imgen_enfermedad']->storeAs(
                $dir,
                $data['imgen_enfermedad']->getClientOriginalName(),
                'public'
            );
        }

        // PDF
        $archivoPathPDF = $pivotActual->pdf_enfermedad;
        if (!empty($data['pdf_enfermedad'])) {
            if ($data['pdf_enfermedad']->getMimeType() !== 'application/pdf') {
                $this->addError('pdf_enfermedad', 'El archivo debe ser un PDF válido.');
                return;
            }
            if ($archivoPathPDF && Storage::disk('public')->exists($archivoPathPDF)) {
                Storage::disk('public')->delete($archivoPathPDF);
            }
            $archivoPathPDF = $data['pdf_enfermedad']->storeAs(
                $dir,
                $data['pdf_enfermedad']->getClientOriginalName(),
                'public'
            );
        }

        // 5) Preparar UPDATE del pivot
        $pivotUpdate = [
            'enfermedade_id'               => $enfermedadeId,
            'fecha_atencion_enfermedad'    => $data['fecha_atencion_enfermedad'] ?? null,
            'fecha_finalizacion_enfermedad'=> $data['fecha_finalizacion_enfermedad'] ?? null,
            'detalle_diagnostico'          => $data['detalle_diagnostico'] ?? null,
            'detalle_medicacion'           => $data['detalle_medicacion'] ?? null,
            'horas_reposo'                 => $data['horas_reposo'] ?? null,
            'medicacion'                   => $data['medicacion'] ?? null,
            'dosis'                        => $data['dosis'] ?? null,
            'nro_osef'                     => $data['nro_osef'] ?? null,
            'art'                          => $data['art'] ?? null,
            'tipodelicencia'               => $data['tipodelicencia'] ?? null,
            'derivacion_psiquiatrica'      => $data['derivacion_psiquiatrica'] ?? null,
            'motivo_consulta'              => $data['motivo_consulta'] ?? null,
            'imgen_enfermedad'             => $archivoPathImg,
            'pdf_enfermedad'               => $archivoPathPDF,
            'updated_at'                   => now(),
        ];

        // 6) UPDATE por id del pivot (fila exacta)
        DB::table('enfermedade_paciente')
            ->where('id', $this->pivotId)
            ->update($pivotUpdate);

        // 7) (Opcional) si editaron el nombre de la enfermedad, actualizar tabla enfermedades
        if (!empty($this->name)) {
            Enfermedade::where('id', $enfermedadeId)->update([
                'name' => $this->name,
                'slug' => Str::slug($this->name),
            ]);
        }

        // 8) Feedback + reset + cerrar modal
        $this->dispatch('swal', title:'Actualizado', text:'La enfermedad fue editada correctamente.', icon:'success');

        $this->reset([
            'modal','pivotId','original_enfermedade_id','enfermedade_id',
            'name','nameSearch','namePickerOpen','nameOptions','nameIndex',
            'fecha_atencion_enfermedad','fecha_finalizacion_enfermedad',
            'detalle_diagnostico','detalle_medicacion','horas_reposo',
            'medicacion','dosis','nro_osef','art','tipodelicencia',
            'derivacion_psiquiatrica','motivo_consulta','imgen_enfermedad','pdf_enfermedad'
        ]);

        $this->resetValidation();
    }

    // ====== Autocomplete del campo "Nombre" dentro del modal ======

    public function openNamePicker()
    {
        if ($this->nameSearch === '' && !empty($this->name)) {
            $this->nameSearch = $this->name;
        }
        $this->namePickerOpen = true;
        $this->updatedNameSearch($this->nameSearch);
    }

    public function closeNamePicker() { $this->namePickerOpen = false; }

    public function updatedNameSearch($value)
    {
        $this->enfermedade_id = null;
        $q = trim((string)$value);

        if ($q === '') {
            $this->nameOptions = [];
            $this->namePickerOpen = false;
            $this->nameIndex = 0;
            return;
        }

        // Si no usás Scout, cambiá esto a ->where('name','like',"%$q%")
        $this->nameOptions = Enfermedade::search($q)
            ->take(10)->get()
            ->map(fn($e) => [
                'id'     => $e->id,
                'name'   => $e->name,
                'codigo' => $e->codigo ?? null,
            ])->toArray();

        $this->namePickerOpen = !empty($this->nameOptions);
        $this->nameIndex = 0;
    }

    public function updatedName($value)
    {
        $this->enfermedade_id = null;
        $this->nameSearch = $value;
        $this->updatedNameSearch($value);
    }

    public function pickEnfermedad($id)
    {
        if ($e = Enfermedade::find($id)) {
            $this->enfermedade_id  = $e->id;
            $this->name            = $e->name;
            $this->nameSearch      = $e->name;
            $this->namePickerOpen  = false;
        }
    }

    public function moveNameDown()
    {
        if (!$this->namePickerOpen) return;
        $this->nameIndex = min($this->nameIndex + 1, max(count($this->nameOptions) - 1, 0));
    }

    public function moveNameUp()
    {
        if (!$this->namePickerOpen) return;
        $this->nameIndex = max($this->nameIndex - 1, 0);
    }

    public function chooseNameHighlighted()
    {
        if ($this->namePickerOpen && isset($this->nameOptions[$this->nameIndex])) {
            $this->pickEnfermedad($this->nameOptions[$this->nameIndex]['id']);
        }
    }

    // =============================================================

    public function render()
    {
        $paciente = Paciente::find($this->pacienteId);

        if ($paciente) {
            $enfermedades = $paciente->enfermedades()
                ->where(function ($query) {
                    $q = '%' . $this->search . '%';
                    $query->where('name', 'like', $q)
                        ->orWhere('codigo', 'like', $q)
                        ->orWhere('enfermedade_paciente.detalle_diagnostico', 'like', $q)
                        ->orWhere('enfermedade_paciente.detalle_medicacion', 'like', $q)
                        ->orWhere('enfermedade_paciente.fecha_finalizacion_enfermedad', 'like', $q)
                        ->orWhere('enfermedade_paciente.horas_reposo', 'like', $q)
                        ->orWhere('enfermedade_paciente.fecha_atencion_enfermedad', 'like', $q)
                        ->orWhere('enfermedade_paciente.medicacion', 'like', $q)
                        ->orWhere('enfermedade_paciente.nro_osef', 'like', $q)
                        ->orWhere('enfermedade_paciente.art', 'like', $q)
                        ->orWhere('enfermedade_paciente.tipodelicencia', 'like', $q)
                        ->orWhere('enfermedade_paciente.derivacion_psiquiatrica', 'like', $q)
                        ->orWhere('enfermedade_paciente.motivo_consulta', 'like', $q);
                })
                ->orderBy('enfermedade_paciente.id', $this->sortAsc ? 'desc' : 'asc')
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            return view('livewire.patient.patient-historial-enfermedades', [
                'paciente'     => $paciente,
                'enfermedades' => $enfermedades,
            ])->layout('layouts.app');
        }

        return view('livewire.patient.patient-historial-enfermedades')->layout('layouts.app');
    }
}
