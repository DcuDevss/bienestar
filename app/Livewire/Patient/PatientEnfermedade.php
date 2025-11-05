<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class PatientEnfermedade extends Component
{
    use WithFileUploads;

    // --- UI / búsqueda ---
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $modal = false;
    public $pickerOpen = false;

    // --- contexto ---
    public $patient;                 // Paciente inyectado en mount
    public $paciente_enfermedades;   // lista para refrescar
    public $pivotId = null;          // 👈 clave para EDICIÓN puntual del pivot

    // --- selección / creación de enfermedad ---
    public $enfermedade_id = null;   // si eligen del listado
    public $name = null;             // si crean nueva por texto

    // --- campos pivot ---
    public $detalle_diagnostico, $fecha_atencion_enfermedad, $fecha_finalizacion_enfermedad,
           $horas_reposo, $medicacion, $dosis, $detalle_medicacion, $motivo_consulta,
           $nro_osef, $tipodelicencia, $art, $estado_enfermedad, $derivacion_psiquiatrica;

    // --- archivos (Livewire) ---
    public $imgen_enfermedad;  // file
    public $pdf_enfermedad;    // file

    protected $rules = [
        'enfermedade_id'                => 'nullable|exists:enfermedades,id',
        'name'                          => 'required_without:enfermedade_id|string|min:2',
        'detalle_diagnostico'           => 'required|string',
        'fecha_atencion_enfermedad'     => 'required|date',
        'fecha_finalizacion_enfermedad' => 'required|date|after_or_equal:fecha_atencion_enfermedad',
        'horas_reposo'                  => 'nullable|integer',
        'pdf_enfermedad'                => 'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad'              => 'nullable|file|mimes:png,jpg,jpeg,gif|max:8192',
        'medicacion'                    => 'nullable|string',
        'dosis'                         => 'nullable|string',
        'motivo_consulta'               => 'nullable|string',
        'derivacion_psiquiatrica'       => 'nullable|string',
        'estado_enfermedad'             => 'nullable|boolean',
        'art'                           => 'nullable|string',
        'detalle_medicacion'            => 'nullable|string',
        'nro_osef'                      => 'nullable|string',
        'tipodelicencia'                => 'required|string',
    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->paciente_enfermedades = $paciente->enfermedades;
    }

    // --- picker de enfermedades ---
    public function openPicker()  { $this->pickerOpen = true; }
    public function closePicker() { $this->pickerOpen = false; }

    public function updatedSearch($value)
    {
        $this->enfermedade_id = null;
        $this->name = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function updatedName($value)
    {
        $this->enfermedade_id = null;
        $this->search = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function pickEnfermedad($id)
    {
        if ($e = Enfermedade::find($id)) {
            $this->enfermedade_id = $e->id;
            $this->name           = $e->name;
            $this->search         = $e->name;
            $this->pickerOpen     = false;
        }
    }

    // --- abrir modal en modo "alta" ---
    public function addModalDisase($enfermedadeId = null)
    {
        $this->resetForm();          // limpia campos/pivotId
        if ($enfermedadeId && $e = Enfermedade::find($enfermedadeId)) {
            $this->name = $e->name;
            $this->enfermedade_id = $e->id;
            $this->search = $e->name;
        }
        $this->pickerOpen = false;
        $this->modal = true;
    }

    // --- abrir modal en modo "edición" de una fila pivot ---
    public function startEdit(int $pivotId)
    {
        $this->resetForm();
        $this->pivotId = $pivotId;

        $row = DB::table('enfermedade_paciente')->where('id', $pivotId)->first();
        if (!$row) {
            $this->dispatch('swal', title:'Error', text:'No se encontró el registro.', icon:'error');
            return;
        }

        // set enfermedad seleccionada
        $this->enfermedade_id = (int) $row->enfermedade_id;
        if ($enf = Enfermedade::find($this->enfermedade_id)) {
            $this->name   = $enf->name;
            $this->search = $enf->name;
        }

        // set campos pivot
        $this->detalle_diagnostico            = $row->detalle_diagnostico;
        $this->fecha_atencion_enfermedad      = $row->fecha_atencion_enfermedad ? (string) $row->fecha_atencion_enfermedad : null;
        $this->fecha_finalizacion_enfermedad  = $row->fecha_finalizacion_enfermedad ? (string) $row->fecha_finalizacion_enfermedad : null;
        $this->horas_reposo                   = $row->horas_reposo;
        $this->medicacion                     = $row->medicacion;
        $this->dosis                          = $row->dosis;
        $this->detalle_medicacion             = $row->detalle_medicacion;
        $this->motivo_consulta                = $row->motivo_consulta;
        $this->nro_osef                       = $row->nro_osef;
        $this->tipodelicencia                 = $row->tipodelicencia;
        $this->art                            = $row->art;
        $this->estado_enfermedad              = (bool) $row->estado_enfermedad;
        $this->derivacion_psiquiatrica        = $row->derivacion_psiquiatrica;

        $this->pickerOpen = false;
        $this->modal = true;
    }

    // === GUARDAR (crea o edita según $pivotId) ===
    public function addDisase()
    {
        $data = $this->validate();

        // 1) resolver enfermedad por ID o crear por SLUG (NO por name directo)
        if (empty($data['enfermedade_id'])) {
            $nombre = mb_strtolower(trim($this->name ?? $this->search ?? ''));
            if ($nombre === '') {
                $this->addError('enfermedade_id', 'Elegí una enfermedad o escribí un nombre.');
                return;
            }
            $slug = Str::slug($nombre);
            $enfermedad = Enfermedade::firstOrCreate(
                ['slug' => $slug],
                ['name' => $nombre, 'codigo' => '']
            );
            $enfermedadeId = $enfermedad->id;
        } else {
            $enfermedadeId = (int) $data['enfermedade_id'];
        }

        // 2) archivos (sólo si llegan nuevos)
        $dir = "archivos_enfermedades/paciente_{$this->patient->id}";
        Storage::disk('public')->makeDirectory($dir);

        $archivoPathEnfermedad = null;
        if ($this->imgen_enfermedad) {
            $archivoPathEnfermedad = $this->imgen_enfermedad->storeAs(
                $dir,
                $this->imgen_enfermedad->getClientOriginalName(),
                'public'
            );
        }

        $archivoPathPDF = null;
        if ($this->pdf_enfermedad) {
            $archivoPathPDF = $this->pdf_enfermedad->storeAs(
                $dir,
                $this->pdf_enfermedad->getClientOriginalName(),
                'public'
            );
        }

        // 3) si hay pivotId => EDICIÓN puntual de esa fila
        if ($this->pivotId) {
            DB::table('enfermedade_paciente')
                ->where('id', $this->pivotId)
                ->update([
                    'enfermedade_id'               => $enfermedadeId,
                    'detalle_diagnostico'          => $this->detalle_diagnostico,
                    'fecha_atencion_enfermedad'    => $this->fecha_atencion_enfermedad,
                    'fecha_finalizacion_enfermedad'=> $this->fecha_finalizacion_enfermedad,
                    'horas_reposo'                 => $this->horas_reposo,
                    'medicacion'                   => $this->medicacion,
                    'dosis'                        => $this->dosis,
                    'detalle_medicacion'           => $this->detalle_medicacion,
                    'motivo_consulta'              => $this->motivo_consulta,
                    'nro_osef'                     => $this->nro_osef,
                    'tipodelicencia'               => $this->tipodelicencia,
                    'art'                          => $this->art,
                    'estado_enfermedad'            => (int) ($this->estado_enfermedad ?? 0),
                    'derivacion_psiquiatrica'      => $this->derivacion_psiquiatrica,
                    // sólo reemplazar si hay archivo nuevo
                    'imgen_enfermedad'             => $archivoPathEnfermedad ?? DB::raw('imgen_enfermedad'),
                    'pdf_enfermedad'               => $archivoPathPDF ?? DB::raw('pdf_enfermedad'),
                    'updated_at'                   => now(),
                ]);

            $this->dispatch('swal', title: 'Actualizado', text: 'Atención médica actualizada.', icon: 'success');
            $this->afterSaveCleanup();
            return;
        }

        // 4) si NO hay pivotId => ALTA (histórico de episodios permitido)
        $this->patient->enfermedades()->attach($enfermedadeId, [
            'fecha_atencion_enfermedad'      => $this->fecha_atencion_enfermedad,
            'detalle_diagnostico'            => $this->detalle_diagnostico,
            'imgen_enfermedad'               => $archivoPathEnfermedad,
            'pdf_enfermedad'                 => $archivoPathPDF,
            'fecha_finalizacion_enfermedad'  => $this->fecha_finalizacion_enfermedad,
            'horas_reposo'                   => $this->horas_reposo,
            'medicacion'                     => $this->medicacion,
            'dosis'                          => $this->dosis,
            'motivo_consulta'                => $this->motivo_consulta,
            'derivacion_psiquiatrica'        => $this->derivacion_psiquiatrica,
            'estado_enfermedad'              => (int) ($this->estado_enfermedad ?? 0),
            'detalle_medicacion'             => $this->detalle_medicacion,
            'nro_osef'                       => $this->nro_osef,
            'tipodelicencia'                 => $this->tipodelicencia,
            'art'                            => $this->art,
            'created_at'                     => now(),
            'updated_at'                     => now(),
        ]);

        $this->dispatch('swal', title: 'Agregado', text: 'Atención médica agregada.', icon: 'success');
        $this->afterSaveCleanup();
    }

    private function afterSaveCleanup(): void
    {
        $this->resetForm();
        $this->paciente_enfermedades = $this->patient->enfermedades()->get();
        $this->modal = false;
        $this->pickerOpen = false;
    }

    private function resetForm(): void
    {
        $this->reset([
            'pivotId',
            'enfermedade_id','name','search',
            'detalle_diagnostico','fecha_atencion_enfermedad','fecha_finalizacion_enfermedad',
            'horas_reposo','medicacion','dosis','detalle_medicacion','motivo_consulta',
            'nro_osef','tipodelicencia','art','estado_enfermedad','derivacion_psiquiatrica',
            'imgen_enfermedad','pdf_enfermedad',
        ]);
    }

    public function addNew()
    {
        // crea nueva enfermedad por SLUG (evita duplicados por may/min)
        $nombre = mb_strtolower(trim($this->search));
        if ($nombre === '') return;

        $slug = Str::slug($nombre);
        $newDisase = Enfermedade::firstOrCreate(['slug' => $slug], ['name' => $nombre, 'codigo' => '']);
        $this->enfermedade_id = $newDisase->id;
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
