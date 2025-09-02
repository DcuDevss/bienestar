<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;

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

    /** dropdown sugerencias */
    public $pickerOpen = false;

    protected $rules = [
        // permitir elegir de la lista o escribir uno nuevo
        'disase_id'                    => 'nullable|exists:disases,id',
        'name'                         => 'required_without:disase_id|string|min:2',

        'fecha_presentacion_certificado'=>'nullable|date',
        'detalle_certificado'          => 'required|string|min:2',
        'fecha_inicio_licencia'        => 'nullable|date',
        'fecha_finalizacion_licencia'  => 'nullable|date|after_or_equal:fecha_inicio_licencia',
        'horas_salud'                  => 'nullable|integer',
        'suma_salud'                   => 'nullable|integer',
        'suma_auxiliar'                => 'nullable|integer',
        'imagen_frente'                => 'nullable|file',
        'imagen_dorso'                 => 'nullable|file',
        'estado_certificado'           => 'nullable|boolean',
        'tipolicencia_id'              => 'required|exists:tipolicencias,id',
    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->disases;
    }

    /** abrir/cerrar dropdown */
    public function openPicker()  { $this->pickerOpen = true; }
    public function closePicker() { $this->pickerOpen = false; }

    /** al tipear (si bindéas el input a search) */
    public function updatedSearch($value)
    {
        $this->disase_id = null;
        $this->name = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    /** si preferís bindear a name */
    public function updatedName($value)
    {
        $this->disase_id = null;
        $this->search = $value;
        $this->pickerOpen = trim($value) !== '';
    }

    /** abrir modal con una ya existente */
    public function addModalDisase($disaseId)
    {
        $disase = Disase::find($disaseId);
        $this->name = $disase->name;
        $this->disase_id = $disase->id;

        $this->search = $disase->name;
        $this->pickerOpen = false;

        $this->modal = true;
    }

    /** elegir de la lista */
    public function pickDisase($id)
    {
        if ($d = Disase::find($id)) {
            $this->disase_id = $d->id;
            $this->name      = $d->name;
            $this->search    = $d->name;
            $this->pickerOpen = false;
        }
    }

    public function addDisase()
    {
        $data = $this->validate();

        // asegurar disase_id
        if (empty($data['disase_id'])) {
            $nombre = mb_strtolower(trim($this->name ?? $this->search ?? ''));
            $new = Disase::firstOrCreate(
                ['name' => $nombre],
                ['slug' => Str::slug($nombre), 'symptoms' => '']
            );
            $disaseId = $new->id;
        } else {
            $disaseId = $data['disase_id'];
        }

        // archivos
        $patientId = $this->patient->id;
        $dir = "public/archivos_disases/paciente_$patientId";
        if (!file_exists($dir)) mkdir($dir, 0777, true);

        $pathFrente = isset($data['imagen_frente'])
            ? $data['imagen_frente']->storeAs($dir, $data['imagen_frente']->getClientOriginalName())
            : null;

        $pathDorso = isset($data['imagen_dorso'])
            ? $data['imagen_dorso']->storeAs($dir, $data['imagen_dorso']->getClientOriginalName())
            : null;

        // pivot
        $this->patient->disases()->attach($disaseId, [
            'fecha_presentacion_certificado' => $data['fecha_presentacion_certificado'] ?? null,
            'fecha_inicio_licencia'          => $data['fecha_inicio_licencia'] ?? null,
            'detalle_certificado'            => $data['detalle_certificado'],
            'imagen_frente'                  => $pathFrente,
            'imagen_dorso'                   => $pathDorso,
            'fecha_finalizacion_licencia'    => $data['fecha_finalizacion_licencia'] ?? null,
            'horas_salud'                    => $data['horas_salud'] ?? null,
            'suma_salud'                     => $data['suma_salud'] ?? null,
            'suma_auxiliar'                  => $data['suma_auxiliar'] ?? null,
            'estado_certificado'             => $data['estado_certificado'] ?? true,
            'tipolicencia_id'                => $this->tipolicencia_id,
        ]);

        // reset
        $this->modal = false;
        $this->pickerOpen = false;
        $this->reset([
            'name','fecha_presentacion_certificado','detalle_certificado','fecha_inicio_licencia',
            'fecha_finalizacion_licencia','horas_salud','suma_salud','suma_auxiliar','tipolicencia_id',
            'tipodelicencia','estado_certificado','imagen_frente','imagen_dorso','search','disase_id'
        ]);

        $this->patient_disases = $this->patient->disases()->get();
        $this->resetValidation();
    }

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
