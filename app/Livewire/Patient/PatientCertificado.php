<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;


class PatientCertificado extends Component
{
    use WithFileUploads;

    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $disaseId;

    public $name, $fecha_presentacion_certificado, $detalle_certificado, $fecha_finalizacion_licencia,
        $fecha_inicio_licencia, $horas_salud, $suma_salud, $estado_certificado, $tipolicencia_id,
        $imagen_frente, $imagen_dorso, $tipodelicencia, $disase_id, $patient_disases, $patient,
        $disase, $suma_auxiliar;

    public $modal = false;
    public $pickerOpen = false;

    protected $rules = [
        'disase_id'                    => 'nullable|exists:disases,id',
        'name'                         => 'required_without:disase_id|string|min:2',
        'fecha_presentacion_certificado' => 'nullable|date',
        'detalle_certificado'          => 'required|string|min:2',
        'fecha_inicio_licencia'        => 'nullable|date',
        'fecha_finalizacion_licencia'  => 'nullable|date|after_or_equal:fecha_inicio_licencia',
        'horas_salud'                  => 'nullable|integer',
        'suma_salud'                   => 'nullable|integer',
        'suma_auxiliar'                => 'nullable|integer',
        'imagen_frente'                => 'nullable|file',
        'imagen_dorso'                 => 'nullable|file',
        'estado_certificado'          => 'nullable|boolean',
        'tipolicencia_id'              => 'required|exists:tipolicencias,id',
    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->disases;
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
        $this->disase_id = null;
        $this->name = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function updatedName($value)
    {
        $this->disase_id = null;
        $this->search = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function updatedFechaInicioLicencia()
    {
        $this->calcularDiasLicencia();
    }

    public function updatedFechaFinalizacionLicencia()
    {
        $this->calcularDiasLicencia();
    }

    public function calcularDiasLicencia()
    {
        if ($this->fecha_inicio_licencia && $this->fecha_finalizacion_licencia) {
            try {
                $inicio = Carbon::parse($this->fecha_inicio_licencia);
                $fin = Carbon::parse($this->fecha_finalizacion_licencia);
                $dias = $inicio->diffInDays($fin) + 1;

                $this->suma_salud = $dias;
                $this->suma_auxiliar = $dias;
            } catch (\Exception $e) {
                $this->suma_salud = null;
                $this->suma_auxiliar = null;
            }
        } else {
            $this->suma_salud = null;
            $this->suma_auxiliar = null;
        }
    }

    public function addModalDisase($disaseId)
    {
        $disase = Disase::find($disaseId);
        $this->name = $disase->name;
        $this->disase_id = $disase->id;

        $this->search = $disase->name;
        $this->pickerOpen = false;
        $this->modal = true;
    }

    public function pickDisase($id)
    {
        if ($d = Disase::find($id)) {
            $this->disase_id = $d->id;
            $this->name = $d->name;
            $this->search = $d->name;
            $this->pickerOpen = false;
        }
    }

    /* public function addDisase()
    {
        $data = $this->validate();

        // Crear o reutilizar enfermedad
        $disaseId = $data['disase_id'] ?? Disase::firstOrCreate(
            ['name' => mb_strtolower(trim($this->name))],
            ['slug' => Str::slug($this->name), 'symptoms' => '']
        )->id;

        // Guardar archivos
        $dir = "archivos_disases/paciente_{$this->patient->id}"; // sin "public/" al inicio
        Storage::disk('public')->makeDirectory($dir);

        $pathFrente = $data['imagen_frente']
            ?->storeAs($dir, $data['imagen_frente']->getClientOriginalName(), 'public');

        $pathDorso  = $data['imagen_dorso']
            ?->storeAs($dir, $data['imagen_dorso']->getClientOriginalName(), 'public');

        // Calcular días (de nuevo por si no se actualizó el frontend)
        $suma_auxiliar = null;
        if ($data['fecha_inicio_licencia'] && $data['fecha_finalizacion_licencia']) {
            $suma_auxiliar = Carbon::parse($data['fecha_inicio_licencia'])
                ->diffInDays(Carbon::parse($data['fecha_finalizacion_licencia'])) + 1;
        }

        // Guardar en pivot
        $this->patient->disases()->attach($disaseId, [
            'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
            'fecha_inicio_licencia'          => $data['fecha_inicio_licencia'],
            'fecha_finalizacion_licencia'    => $data['fecha_finalizacion_licencia'],
            'detalle_certificado'            => $data['detalle_certificado'],
            'imagen_frente'                  => $pathFrente,
            'imagen_dorso'                   => $pathDorso,
            'horas_salud'                    => $data['horas_salud'],
            'suma_salud'                     => $data['suma_salud'],
            'suma_auxiliar'                  => $suma_auxiliar,
            'estado_certificado'             => $data['estado_certificado'] ?? true,
            'tipolicencia_id'                => $data['tipolicencia_id'],
        ]);

        $this->reset([
            'name','fecha_presentacion_certificado','detalle_certificado','fecha_inicio_licencia',
            'fecha_finalizacion_licencia','horas_salud','suma_salud','suma_auxiliar','tipolicencia_id',
            'tipodelicencia','estado_certificado','imagen_frente','imagen_dorso','search','disase_id'
        ]);

        $this->modal = false;
        $this->pickerOpen = false;
        $this->resetValidation();
        $this->patient_disases = $this->patient->disases()->get();
    } */

        /* separador */
    public function addDisase()
    {
        $data = $this->validate();

        // Crear o reutilizar enfermedad
        $disaseId = $data['disase_id'] ?? Disase::firstOrCreate(
            ['name' => mb_strtolower(trim($this->name))],
            ['slug' => Str::slug($this->name), 'symptoms' => '']
        )->id;

        // Carpeta destinoa
        $dir = "archivos_disases/paciente_{$this->patient->id}";
        Storage::disk('public')->makeDirectory($dir);

        // Optimizar y guardar imágenes
        $pathFrente = $this->optimizarImagen($data['imagen_frente'], $dir);
        $pathDorso  = $this->optimizarImagen($data['imagen_dorso'], $dir);

        // Calcular días
        $suma_auxiliar = null;
        if ($data['fecha_inicio_licencia'] && $data['fecha_finalizacion_licencia']) {
            $suma_auxiliar = Carbon::parse($data['fecha_inicio_licencia'])
                ->diffInDays(Carbon::parse($data['fecha_finalizacion_licencia'])) + 1;
        }

        // Guardar en pivot
        $this->patient->disases()->attach($disaseId, [
            'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'],
            'fecha_inicio_licencia'          => $data['fecha_inicio_licencia'],
            'fecha_finalizacion_licencia'    => $data['fecha_finalizacion_licencia'],
            'detalle_certificado'            => $data['detalle_certificado'],
            'imagen_frente'                  => $pathFrente,
            'imagen_dorso'                   => $pathDorso,
            'horas_salud'                    => $data['horas_salud'],
            'suma_salud'                     => $data['suma_salud'],
            'suma_auxiliar'                  => $suma_auxiliar,
            'estado_certificado'             => $data['estado_certificado'] ?? true,
            'tipolicencia_id'                => $data['tipolicencia_id'],
        ]);

        $this->reset([
            'name',
            'fecha_presentacion_certificado',
            'detalle_certificado',
            'fecha_inicio_licencia',
            'fecha_finalizacion_licencia',
            'horas_salud',
            'suma_salud',
            'suma_auxiliar',
            'tipolicencia_id',
            'tipodelicencia',
            'estado_certificado',
            'imagen_frente',
            'imagen_dorso',
            'search',
            'disase_id'
        ]);
        session()->flash('success', 'Certificado agegado correctamente.');
        $this->modal = false;
        $this->pickerOpen = false;
        $this->resetValidation();
        $this->patient_disases = $this->patient->disases()->get();

    }

    /**
     * Optimiza la imagen reduciendo su peso y guardándola en disco
     */
    private function optimizarImagen($file, $dir)
    {
        if (!$file) return null;

        $extension = strtolower($file->getClientOriginalExtension());
        $filename  = uniqid() . '_' . $file->getClientOriginalName();
        $path      = storage_path("app/public/{$dir}/{$filename}");

        // Crear recurso según extensión
        switch ($extension) {
            case 'png':
                $image = imagecreatefrompng($file->getRealPath());
                // convertir a JPEG con compresión
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                $filename = pathinfo($filename, PATHINFO_FILENAME) . '.jpg';
                return "{$dir}/{$filename}";
            case 'jpg':
            case 'jpeg':
                $image = imagecreatefromjpeg($file->getRealPath());
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                return "{$dir}/{$filename}";
            case 'webp':
                $image = imagecreatefromwebp($file->getRealPath());
                imagejpeg($image, $path, 60);
                imagedestroy($image);
                $filename = pathinfo($filename, PATHINFO_FILENAME) . '.jpg';
                return "{$dir}/{$filename}";
            default:
                // Si no lo reconozco, lo guardo normal
                return $file->storeAs($dir, $filename, 'public');
        }
    }

    /* separador */

    public function addNew()
    {
        $newDisase = Disase::create([
            'name' => mb_strtolower($this->search),
            'slug' => Str::slug($this->search),
            'symptoms' => '',
        ]);
        $this->disase = $newDisase;
        $this->name = $newDisase->name;
        $this->addModalDisase($newDisase->id);
    }

    public function render()
    {
        $tipolicencias = Tipolicencia::all();
        $disases = $this->search
            ? Disase::search($this->search)->take(10)->get()
            : collect();

        return view('livewire.patient.patient-certificado', [
            'disases'       => $disases,
            'tipolicencias' => $tipolicencias,
        ]);
    }
}
