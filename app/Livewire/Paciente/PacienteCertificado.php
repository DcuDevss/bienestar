<?php

namespace App\Livewire\Paciente;

use App\Models\Enfermedade;
use App\Models\Paciente;
use App\Models\Enfermedade_paciente;
use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Str;

class PacienteCertificado extends Component
{
    use WithFileUploads;

    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $enfermedadeId;
    public $name, $fecha_enfermedad, $detalle_enfermedad2, $fecha_finalizacion, $fecha_atencion2, $horas_reposo2, $activo, $tipolicencia_id,
        $enfermedade_id, $patient_enfermedades, $patient, $enfermedade, $archivo, $tipodelicencia;

    public $modal = false;
    public $archivos = [];
    public $pacienteId;


    protected $rules = [
        'archivos.*' => 'file|mimes:pdf|max:10240', // Máximo 10 MB por archivo
        'pacienteId' => 'required|exists:pacientes,id',

        'name' => 'required',
       // 'fecha_enfermedad' => 'nullable',
        'fecha_atencion2' => 'nullable',
        'detalle_enfermedad2' => 'required',
        'enfermedade_id' => 'required',
        //'archivo' => 'nullable|file',
        //'fecha_finalizacion' => 'nullable',
        'horas_reposo2' => 'nullable',
        //'activo' => 'nullable',
        //'tipolicencia_id' => 'nullable',
        //'tipodelicencia' => 'nullable'
    ];

    public function mount(Paciente $paciente)
    {
        $this->patient = $paciente;
        $this->patient_enfermedades = $paciente->enfermedadPacientes;
    }

    public function addModalEnfermedade($enfermedadeId)
    {
        $enfermedade = Enfermedade::find($enfermedadeId);
        $this->name = $enfermedade->name;
        $this->enfermedade_id = $enfermedade->id;
        $this->modal = true;
    }

    public function addModalDisase($enfermedadeId)
    {
        $enfermedade = Enfermedade::find($enfermedadeId);
        $this->name = $enfermedade->name;
        $this->enfermedade_id = $enfermedade->id;
        $this->modal = true;
    }




    public function addEnfermedade()
    {
        $data = $this->validate();

        // Obtener el ID del paciente
        $patientId = $this->patient->id;

        // Crear el directorio si no existe
       /* $directoryPath = "public/archivos_enfermedades/paciente_$patientId";
        if (!file_exists($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Manejar la carga del archivo
        if (isset($data['archivo'])) {
            $archivoPath = $data['archivo']->storeAs($directoryPath, $data['archivo']->getClientOriginalName());
        } else {
            $archivoPath = null;
        }*/



        $this->patient->enfermedadPacientes()->create([
            'enfermedade_id' => $data['enfermedade_id'],
           // 'fecha_enfermedad' => $data['fecha_enfermedad'],
            'fecha_atencion2' => $data['fecha_atencion2'],
            'detalle_enfermedad2' => $data['detalle_enfermedad2'],
          //'archivo' => $archivoPath,
            //'fecha_finalizacion' => $data['fecha_finalizacion'],
            'horas_reposo2' => $data['horas_reposo2'],
            //'activo' => isset($data['activo']) ? $data['activo'] : true,
            //'tipodelicencia' => $data['tipodelicencia']
        ]);

        $this->modal = false;

        $this->reset([
            'name',
            //'fecha_enfermedad',
            'detalle_enfermedad2',
            'fecha_atencion2',
            //'fecha_finalizacion',
            'horas_reposo2',
            //'tipolicencia_id',
            //'tipodelicencia',
            //'activo',
            //'archivo',
            'search'
        ]);

        $this->patient_enfermedades = $this->patient->enfermedadPacientes;
    }

    public function addNew()
    {
        $newEnfermedade = Enfermedade::create([
            'name' => mb_strtolower($this->search),
            'slug' => Str::slug($this->search),
            // Otros campos de Enfermedade
        ]);
        $this->enfermedade = $newEnfermedade;
        $this->name = $newEnfermedade->name;
        $this->addModalEnfermedade($newEnfermedade->id);
    }

    public function render()
    {
        if ($this->search) {
            $enfermedades = Enfermedade::search($this->search)->get();
        } else {
            $enfermedades = [];
        }


        return view('livewire.paciente.paciente-certificado', ['enfermedades' => $enfermedades]);
    }
}
