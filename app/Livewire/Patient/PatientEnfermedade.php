<?php

namespace App\Livewire\Patient;

use App\Models\Disase;
use App\Models\Enfermedade;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\Component;
use App\Models\Tipolicencia;
use Livewire\WithFileUploads;
use Carbon\Carbon;


class PatientEnfermedade extends Component
{
    use WithFileUploads;
    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $disaseId;
    public $name, $fecha_enfermedad, $tipo_enfermedad,$fecha_finalizacion,$fecha_atencion,$activo,$tipolicencia_id,
    $disase_id, $paciente_enfermedades, $patient, $disase, $archivo,$enfermedade;

    public $modal = false;

    public $detalle_diagnostico,$fecha_atencion_enfermedad,$fecha_finalizacion_enfermedad,$horas_reposo,$pdf_enfermedad,
    $imgen_enfermedad,$medicacion,$dosis,$detalle_medicacion,$nro_osef,$tipodelicencia,$enfermedade_id,$art,$motivo_consulta,
    $estado_enfermedad,$derivacion_psiquiatrica;



    protected $rules = [
        'enfermedade_id'              => 'nullable|exists:enfermedades,id',
        'name'                        => 'required_without:enfermedade_id|string|min:2',
        'detalle_diagnostico'         => 'nullable',
        'fecha_atencion_enfermedad'   => 'nullable|date',
        'fecha_finalizacion_enfermedad'=> 'nullable|date|after_or_equal:fecha_atencion_enfermedad',
        'horas_reposo'                => 'nullable|integer',
        'pdf_enfermedad'              => 'nullable|file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'imgen_enfermedad'            => 'nullable|file|mimes:png,jpg,jpeg,gif|max:8192',
        'medicacion'                  => 'nullable',
        'dosis'                       => 'nullable',
        'motivo_consulta'             => 'nullable',
        'derivacion_psiquiatrica'     => 'nullable',
        'estado_enfermedad'           => 'nullable|boolean',
        'art'                         => 'nullable',
        'detalle_medicacion'          => 'nullable',
        'nro_osef'                    => 'nullable',
        'tipodelicencia'              => 'nullable',
    ];


   /* public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_disases = $paciente->enfermedades;
    }*/

    public function mount(Paciente $paciente)
{
    $this->patient = $paciente;
    $this->paciente_enfermedades = $paciente->enfermedades;
}

   public function addModalDisase($enfermedadeId)
    {
        $enfermedade = Enfermedade::find($enfermedadeId);
        $this->name = $enfermedade->name;
        $this->enfermedade_id = $enfermedade->id;
        $this->modal = true;
    }



    public function addDisase()
    {
        $data = $this->validate();

        // 1) Resolver la enfermedad (si no viene id, crearla)
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

        // 2) Directorio y archivos (si querés dejá tu versión; esto funciona igual)
        $patientId = $this->patient->id;
        $directoryPath = "public/archivos_enfermedades/paciente_$patientId";
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        $archivoPathEnfermedad = isset($data['imgen_enfermedad'])
            ? $data['imgen_enfermedad']->storeAs($directoryPath, $data['imgen_enfermedad']->getClientOriginalName())
            : null;

        $archivoPathPDF = isset($data['pdf_enfermedad'])
            ? $data['pdf_enfermedad']->storeAs($directoryPath, $data['pdf_enfermedad']->getClientOriginalName())
            : null;

        // 3) Guardar en PIVOTE (SIN 'name')
        $this->patient->enfermedades()->syncWithoutDetaching([
            $enfermedadeId => [
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
            ],
        ]);

        // 4) Reset
        $this->modal = false;
        $this->reset([
            'name','detalle_diagnostico','fecha_atencion_enfermedad','fecha_finalizacion_enfermedad',
            'horas_reposo','dosis','tipolicencia_id','tipodelicencia','art','motivo_consulta',
            'derivacion_psiquiatrica','estado_enfermedad','imgen_enfermedad','medicacion',
            'detalle_medicacion','pdf_enfermedad','nro_osef','search','enfermedade_id'
        ]);
        $this->paciente_enfermedades = $this->patient->enfermedades()->get();
        $this->resetValidation();
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

        if ($this->search) {
            $enfermedades = Enfermedade::search($this->search)->take(10)->get();
        } else {
            $enfermedades = [];
        }

        return view('livewire.patient.patient-enfermedade', ['enfermedades' => $enfermedades, 'tipolicencias' => $tipolicencias]);
    }

}
