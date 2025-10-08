<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use App\Models\Paciente;
use App\Models\Tipolicencia;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class PatientCertificado extends Component
{
    use WithFileUploads;

    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $disaseId;

    public $name, $fecha_presentacion_certificado, $detalle_certificado, $fecha_finalizacion_licencia,
        $fecha_inicio_licencia, $horas_salud, $suma_salud, $suma_auxiliar, $estado_certificado,
        $tipolicencia_id, $imagen_frente, $imagen_dorso, $tipodelicencia, $disase_id,
        $patient_disases, $patient, $disase;

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
        'imagen_frente'                => 'nullable|file|image|max:5120', // 5MB
        'imagen_dorso'                 => 'nullable|file|image|max:5120',
        'estado_certificado'           => 'nullable|boolean',
        'tipolicencia_id'              => 'required|exists:tipolicencias,id',
    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->disases;

        Log::info('📋 Componente PatientCertificado montado', [
            'paciente_id' => $paciente->id,
            'total_disases' => $this->patient_disases->count(),
        ]);
    }

    // ---------------- Picker control ----------------
    public function openPicker()
    {
        Log::debug('🔍 Picker abierto');
        $this->pickerOpen = true;
    }

    public function closePicker()
    {
        Log::debug('❌ Picker cerrado');
        $this->pickerOpen = false;
    }

    // ---------------- Eventos de búsqueda ----------------
    public function updatedSearch($value)
    {
        Log::debug('🔄 updatedSearch()', ['valor' => $value]);
        $this->disase_id = null;
        $this->name = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    public function updatedName($value)
    {
        Log::debug('🔄 updatedName()', ['valor' => $value]);
        $this->disase_id = null;
        $this->search = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    // ---------------- Cálculo de días ----------------
    public function updatedFechaInicioLicencia()
    {
        Log::debug('📅 Fecha inicio modificada', ['inicio' => $this->fecha_inicio_licencia]);
        $this->calcularDiasLicencia();
    }

    public function updatedFechaFinalizacionLicencia()
    {
        Log::debug('📅 Fecha fin modificada', ['fin' => $this->fecha_finalizacion_licencia]);
        $this->calcularDiasLicencia();
    }

    public function calcularDiasLicencia()
    {
        try {
            if ($this->fecha_inicio_licencia && $this->fecha_finalizacion_licencia) {
                $inicio = Carbon::parse($this->fecha_inicio_licencia);
                $fin = Carbon::parse($this->fecha_finalizacion_licencia);
                $dias = $inicio->diffInDays($fin) + 1;

                $this->suma_salud = $dias;
                $this->suma_auxiliar = $dias;

                Log::info('✅ Días licencia calculados', ['días' => $dias]);
            } else {
                $this->suma_salud = null;
                $this->suma_auxiliar = null;
                Log::warning('⚠️ No se pudieron calcular días, faltan fechas');
            }
        } catch (\Exception $e) {
            Log::error('❌ Error calculando días de licencia', ['error' => $e->getMessage()]);
            $this->suma_salud = null;
            $this->suma_auxiliar = null;
        }
    }

    // ---------------- Manejo de enfermedades ----------------
    public function addModalDisase($disaseId)
    {
        Log::info('🩺 Abriendo modal enfermedad', ['disase_id' => $disaseId]);
        $disase = Disase::find($disaseId);

        if (!$disase) {
            Log::warning('⚠️ Enfermedad no encontrada', ['id' => $disaseId]);
            return;
        }

        $this->name = $disase->name;
        $this->disase_id = $disase->id;
        $this->search = $disase->name;
        $this->pickerOpen = false;
        $this->modal = true;
    }

    public function pickDisase($id)
    {
        Log::debug('🩻 Enfermedad seleccionada', ['id' => $id]);
        if ($d = Disase::find($id)) {
            $this->disase_id = $d->id;
            $this->name = $d->name;
            $this->search = $d->name;
            $this->pickerOpen = false;
        } else {
            Log::warning('⚠️ No se encontró la enfermedad con id', ['id' => $id]);
        }
    }

    // ---------------- Guardado de certificado ----------------
    public function addDisase()
    {
        Log::info('🧾 Iniciando creación de certificado');
        try {
            $data = $this->validate();
            Log::debug('📋 Datos validados', $data);

            // Crear o buscar enfermedad
            $disaseId = $data['disase_id'] ?? Disase::firstOrCreate(
                ['name' => mb_strtolower(trim($this->name))],
                ['slug' => Str::slug($this->name), 'symptoms' => '']
            )->id;

            // Carpeta de destino
            $dir = "archivos_disases/paciente_{$this->patient->id}";
            Storage::disk('public')->makeDirectory($dir);
            Log::debug('📁 Directorio creado', ['dir' => $dir]);

            // Procesar imágenes
            $pathFrente = $this->optimizarImagen($data['imagen_frente'], $dir);
            $pathDorso  = $this->optimizarImagen($data['imagen_dorso'], $dir);

            // Recalcular días
            $suma_auxiliar = null;
            if ($data['fecha_inicio_licencia'] && $data['fecha_finalizacion_licencia']) {
                $suma_auxiliar = Carbon::parse($data['fecha_inicio_licencia'])
                    ->diffInDays(Carbon::parse($data['fecha_finalizacion_licencia'])) + 1;
            }

            // Guardar pivot
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

            Log::info('✅ Certificado agregado correctamente', [
                'disase_id' => $disaseId,
                'imagen_frente' => $pathFrente,
                'imagen_dorso' => $pathDorso,
            ]);

            // Reset
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

            session()->flash('success', 'Certificado agregado correctamente.');
            $this->modal = false;
            $this->pickerOpen = false;
            $this->resetValidation();
            $this->patient_disases = $this->patient->disases()->get();
        } catch (\Exception $e) {
            Log::error('❌ Error al agregar certificado', [
                'mensaje' => $e->getMessage(),
                'linea' => $e->getLine(),
                'archivo' => $e->getFile(),
            ]);
            session()->flash('error', 'Ocurrió un error al agregar el certificado.');
        }
    }

    // ---------------- Optimización de imágenes ----------------
    private function optimizarImagen($file, $dir)
    {
        if (!$file) return null;
        Log::debug('🖼️ Optimizando imagen', ['nombre' => $file->getClientOriginalName()]);

        try {
            $extension = strtolower($file->getClientOriginalExtension());
            $baseName  = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $filename  = uniqid() . '_' . Str::slug($baseName) . '.jpg';
            $path      = storage_path("app/public/{$dir}/{$filename}");

            switch ($extension) {
                case 'png':
                    $image = imagecreatefrompng($file->getRealPath());
                    break;
                case 'jpg':
                case 'jpeg':
                    $image = imagecreatefromjpeg($file->getRealPath());
                    break;
                case 'webp':
                    $image = imagecreatefromwebp($file->getRealPath());
                    break;
                default:
                    // Si no es imagen compatible, se guarda como está
                    return $file->storeAs($dir, $file->getClientOriginalName(), 'public');
            }

            // Guardar imagen optimizada
            imagejpeg($image, $path, 70);
            imagedestroy($image);

            Log::info('🖼️ Imagen optimizada correctamente', ['ruta' => "{$dir}/{$filename}"]);
            return "{$dir}/{$filename}";
        } catch (\Exception $e) {
            Log::error('❌ Error optimizando imagen', [
                'archivo' => $file->getClientOriginalName(),
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    // ---------------- Crear nueva enfermedad desde búsqueda ----------------
    public function addNew()
    {
        Log::info('➕ Creando nueva enfermedad desde búsqueda', ['search' => $this->search]);
        $newDisase = Disase::create([
            'name' => mb_strtolower($this->search),
            'slug' => Str::slug($this->search),
            'symptoms' => '',
        ]);
        $this->disase = $newDisase;
        $this->name = $newDisase->name;
        $this->addModalDisase($newDisase->id);
    }

    // ---------------- Render del componente ----------------
    public function render()
    {
        Log::debug('🎨 Renderizando componente PatientCertificado');
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
