<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Attributes\Url;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class PatientHistorialCertificado extends Component
{
    use WithPagination, WithFileUploads;

    public $name, $fecha_presentacion_certificado, $detalle_certificado, $fecha_finalizacion_licencia, $fecha_inicio_licencia,
        $horas_salud, $suma_salud, $estado_certificado, $tipolicencia_id, $imagen_frente, $imagen_dorso, $tipodelicencia,
        $disase_id, $patient_disases, $patient, $disase, $suma_auxiliar;

    public $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $activo,
        $paciente_id, $disases, $archivo;

    public $selectedDisase;
    public $modal = false;
    public $modalEdit = false;

    public $editedDisaseName;       // campo que editás en el modal
    public $pacienteId;

    public $sortAsc = true;
    #[Url(history: true)] public $search = '';
    #[Url(history: true)] public $admin = '';
    #[Url(history: true)] public $sortBy = 'created_at';
    #[Url(history: true)] public $sortDir = 'DESC';
    #[Url()]            public $perPage = 4;

    // --- Autocomplete dentro del modal ---
    public $editPickerOpen = false;
    public $editOptions = [];
    public $editIndex = 0;
    public $original_disase_id = null; // para detectar cambio y mover el pivot

    protected $rules = [
        'name'                           => 'required',
        'fecha_presentacion_certificado' => 'nullable|date',
        'detalle_certificado'            => 'required',
        'fecha_inicio_licencia'          => 'nullable|date',
        'fecha_finalizacion_licencia'    => 'nullable|date|after_or_equal:fecha_inicio_licencia',
        'horas_salud'                    => 'nullable|integer',
        'suma_salud'                     => 'nullable|integer',
        'imagen_frente'                  => 'nullable|file',
        'imagen_dorso'                   => 'nullable|file',
        'estado_certificado'             => 'nullable|boolean',
        'tipolicencia_id'                => 'nullable',
        'disase_id'                      => 'required', // debe elegir una opción
        'suma_auxiliar'                  => 'nullable|integer',
    ];

    public function mount($paciente)
    {
        $this->pacienteId = $paciente;
    }

    /** Abre el modal con datos y prepara autocomplete */
    public function editModalDisase($disaseId)
    {
        $paciente = \App\Models\Paciente::with(['disases' => function ($q) use ($disaseId) {
            $q->where('disases.id', $disaseId);
        }])->find($this->pacienteId);

        if ($paciente && $paciente->disases->isNotEmpty()) {
            $d = $paciente->disases->first();

            $this->name                          = $d->name;
            $this->editedDisaseName              = $d->name;
            $this->disase_id                     = $d->id;
            $this->original_disase_id            = $d->id;

            $this->fecha_presentacion_certificado = $d->pivot->fecha_presentacion_certificado ?? null;
            $this->fecha_inicio_licencia          = $d->pivot->fecha_inicio_licencia ?? null;
            $this->fecha_finalizacion_licencia    = $d->pivot->fecha_finalizacion_licencia ?? null;
            $this->horas_salud                    = $d->pivot->horas_salud ?? null;
            $this->suma_salud                     = $d->pivot->suma_salud ?? null;
            $this->suma_auxiliar                  = $d->pivot->suma_auxiliar ?? null;
            $this->estado_certificado             = $d->pivot->estado_certificado ?? null;
            $this->detalle_certificado            = $d->pivot->detalle_certificado ?? null;
            $this->tipolicencia_id                = $d->pivot->tipolicencia_id ?? null;

            $this->modal = true;
            $this->editPickerOpen = false; // no abrir automáticamente
        }
    }

    /** Buscar sugerencias al tipear en el input del modal */
    public function updatedEditedDisaseName($value)
    {
        $this->disase_id = null; // obliga a elegir una
        $q = trim((string)$value);

        if ($q === '') {
            $this->editOptions = [];
            $this->editPickerOpen = false;
            $this->editIndex = 0;
            return;
        }

        $this->editOptions = \App\Models\Disase::query()
            ->where('name', 'like', "%{$q}%")
            ->orderBy('name')
            ->limit(10)
            ->get(['id', 'name'])
            ->toArray();

        $this->editPickerOpen = !empty($this->editOptions);
        $this->editIndex = 0;
    }

    public function openEditPicker()
    {
        $this->editPickerOpen = true;
    }
    public function closeEditPicker()
    {
        $this->editPickerOpen = false;
    }

    /** Seleccionar una sugerencia */
    public function pickEditedDisase($id)
    {
        if ($d = \App\Models\Disase::find($id)) {
            $this->disase_id        = $d->id;
            $this->editedDisaseName = $d->name;
            $this->editPickerOpen   = false;
        }
    }

    /** Guardar cambios */
    /* public function editDisase()
    {
        $data = $this->validate();

        $paciente = \App\Models\Paciente::find($this->pacienteId);
        $disase   = $paciente->disases()->findOrFail($this->original_disase_id);

        $dir = "public/archivos_disases/paciente_{$paciente->id}";

        // imagen frente
        if (isset($data['imagen_frente'])) {
            $archivoPath = $data['imagen_frente']->storeAs($dir, $data['imagen_frente']->getClientOriginalName());
            if (!str_starts_with($data['imagen_frente']->getMimeType(), 'image/')) {
                $this->addError('imagen_frente', 'El imagen_frente debe ser una imagen.');
                return;
            }
        } else {
            $archivoPath = $disase->pivot->imagen_frente;
        }

        // imagen dorso
        if (isset($data['imagen_dorso'])) {
            $archivoPathDorso = $data['imagen_dorso']->storeAs($dir, $data['imagen_dorso']->getClientOriginalName());
            if (!str_starts_with($data['imagen_dorso']->getMimeType(), 'image/')) {
                $this->addError('imagen_dorso', 'El imagen_dorso debe ser una imagen.');
                return;
            }
        } else {
            $archivoPathDorso = $disase->pivot->imagen_dorso;
        }
        $suma_auxiliar = null;
            if (!empty($data['fecha_inicio_licencia']) && !empty($data['fecha_finalizacion_licencia'])) {
                $suma_auxiliar = \Carbon\Carbon::parse($data['fecha_inicio_licencia'])
                    ->diffInDays(\Carbon\Carbon::parse($data['fecha_finalizacion_licencia'])) + 1;
            }
        // Datos del pivot
        $pivotData = [
            'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
            'fecha_inicio_licencia'          => $data['fecha_inicio_licencia'],
            'detalle_certificado'            => $data['detalle_certificado'],
            'imagen_frente'                  => $archivoPath,
            'imagen_dorso'                   => $archivoPathDorso,
            'fecha_finalizacion_licencia'    => $data['fecha_finalizacion_licencia'],
            'horas_salud'                    => $data['horas_salud'],
            'suma_salud'                     => $suma_auxiliar,
            'suma_auxiliar'                  => $suma_auxiliar,
            'estado_certificado'             => isset($data['estado_certificado']) ? $data['estado_certificado'] : true,
            'tipolicencia_id'                => $data['tipolicencia_id'],
        ];

        $changed = ($this->disase_id != $this->original_disase_id);

        if ($changed) {
            // Cambió el padecimiento → mover pivot
            $paciente->disases()->detach($this->original_disase_id);
            $paciente->disases()->attach($this->disase_id, $pivotData);
        } else {
            // Mismo padecimiento → mantener tu lógica de renombrar el modelo
            $disase->update([
                'name' => $this->editedDisaseName,
                'slug' => Str::slug($this->editedDisaseName),
            ]);
            $paciente->disases()->updateExistingPivot($this->disase_id, $pivotData);
        }

        // cerrar modal / limpiar
        $this->modal = false;
        $this->dispatch('toast', type: 'success', message: 'Padecimiento actualizado correctamente');

        $this->reset([
            'name','editedDisaseName','fecha_presentacion_certificado','detalle_certificado',
            'fecha_inicio_licencia','fecha_finalizacion_licencia','horas_salud','suma_salud','suma_auxiliar',
            'tipolicencia_id','estado_certificado','imagen_frente','imagen_dorso','search',
            'editPickerOpen','editOptions','editIndex','original_disase_id'
        ]);

        $this->patient_disases = $paciente->disases()->get();
        $this->resetValidation();
        $this->render();
    } */

    /* separador < */

    /** Guardar cambios */
    public function editDisase()
    {
        $data = $this->validate();

        $paciente = \App\Models\Paciente::find($this->pacienteId);
        $disase   = $paciente->disases()->findOrFail($this->original_disase_id);

        $dir = "public/archivos_disases/paciente_{$paciente->id}";

        // imagen frente
        if (isset($data['imagen_frente'])) {
            if (!str_starts_with($data['imagen_frente']->getMimeType(), 'image/')) {
                $this->addError('imagen_frente', 'El imagen_frente debe ser una imagen.');
                return;
            }

            $archivoPath = $data['imagen_frente']->storeAs($dir, $data['imagen_frente']->getClientOriginalName());

            // optimizar después de guardar
            $this->optimizarImagen(storage_path('app/' . $archivoPath));
        } else {
            $archivoPath = $disase->pivot->imagen_frente;
        }

        // imagen dorso
        if (isset($data['imagen_dorso'])) {
            if (!str_starts_with($data['imagen_dorso']->getMimeType(), 'image/')) {
                $this->addError('imagen_dorso', 'El imagen_dorso debe ser una imagen.');
                return;
            }

            $archivoPathDorso = $data['imagen_dorso']->storeAs($dir, $data['imagen_dorso']->getClientOriginalName());

            // optimizar después de guardar
            $this->optimizarImagen(storage_path('app/' . $archivoPathDorso));
        } else {
            $archivoPathDorso = $disase->pivot->imagen_dorso;
        }

        $suma_auxiliar = null;
        if (!empty($data['fecha_inicio_licencia']) && !empty($data['fecha_finalizacion_licencia'])) {
            $suma_auxiliar = \Carbon\Carbon::parse($data['fecha_inicio_licencia'])
                ->diffInDays(\Carbon\Carbon::parse($data['fecha_finalizacion_licencia'])) + 1;
        }

        // Datos del pivot
        $pivotData = [
            'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
            'fecha_inicio_licencia'          => $data['fecha_inicio_licencia'],
            'detalle_certificado'            => $data['detalle_certificado'],
            'imagen_frente'                  => $archivoPath,
            'imagen_dorso'                   => $archivoPathDorso,
            'fecha_finalizacion_licencia'    => $data['fecha_finalizacion_licencia'],
            'horas_salud'                    => $data['horas_salud'],
            'suma_salud'                     => $suma_auxiliar,
            'suma_auxiliar'                  => $suma_auxiliar,
            'estado_certificado'             => $data['estado_certificado'] ?? true,
            'tipolicencia_id'                => $data['tipolicencia_id'],
        ];

        $changed = ($this->disase_id != $this->original_disase_id);

        if ($changed) {
            // Cambió el padecimiento → mover pivot
            $paciente->disases()->detach($this->original_disase_id);
            $paciente->disases()->attach($this->disase_id, $pivotData);
        } else {
            // Mismo padecimiento → mantener tu lógica de renombrar el modelo
            $disase->update([
                'name' => $this->editedDisaseName,
                'slug' => Str::slug($this->editedDisaseName),
            ]);
            $paciente->disases()->updateExistingPivot($this->disase_id, $pivotData);
        }

        // cerrar modal / limpiar
        $this->modal = false;
        $this->dispatch('toast', type: 'success', message: 'Padecimiento actualizado correctamente');

        $this->reset([
            'name',
            'editedDisaseName',
            'fecha_presentacion_certificado',
            'detalle_certificado',
            'fecha_inicio_licencia',
            'fecha_finalizacion_licencia',
            'horas_salud',
            'suma_salud',
            'suma_auxiliar',
            'tipolicencia_id',
            'estado_certificado',
            'imagen_frente',
            'imagen_dorso',
            'search',
            'editPickerOpen',
            'editOptions',
            'editIndex',
            'original_disase_id'
        ]);

        $this->patient_disases = $paciente->disases()->get();
        $this->resetValidation();
        $this->render();
    }

    /**
     * Optimiza la imagen reduciendo su peso (sobrescribe el archivo)
     */
    private function optimizarImagen($path)
    {
        if (!file_exists($path)) return;

        $info = pathinfo($path);
        $extension = strtolower($info['extension']);

        switch ($extension) {
            case 'png':
                $image = imagecreatefrompng($path);
                imagejpeg($image, $path, 60); // la convierte a JPG con calidad 60
                imagedestroy($image);
                break;
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($path);
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                break;
            case 'webp':
                $image = imagecreatefromwebp($path);
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                break;
            default:
                // otros formatos no se optimizann
                break;
        }
    }



    /*  separador > */

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function delete(Paciente $paciente)
    {
        $paciente->delete();
    }
    public function setSortBy($f)
    {
        if ($this->sortBy === $f) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }
        $this->sortBy = $f;
        $this->sortDir = 'DESC';
    }

    public function render()
    {
        $paciente = Paciente::find($this->pacienteId);
        $tipolicencias = \App\Models\Tipolicencia::all()->keyBy('id');

        if ($paciente) {
            $enfermedades = $paciente->disases()
                ->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.detalle_certificado', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.fecha_inicio_licencia', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.fecha_finalizacion_licencia', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.horas_salud', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.fecha_presentacion_certificado', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.estado_certificado', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.suma_auxiliar', 'like', '%' . $this->search . '%')
                        ->orWhere('disase_paciente.tipolicencia_id', 'like', '%' . $this->search . '%');
                })
                ->orderBy('disase_paciente.id', $this->sortAsc ? 'desc' : 'asc')
                ->paginate($this->perPage, ['*'], 'enfermedades_page');

            return view('livewire.patient.patient-historial-certificado', [
                'paciente' => $paciente,
                'enfermedades' => $enfermedades,
                'tipolicencias' => $tipolicencias,
            ])->layout('layouts.app');
        }

        return view('livewire.patient.patient-historial-certificado')->layout('layouts.app');
    }
}
