<?php

namespace App\Livewire\Paciente;


use Livewire\Component;
use App\Models\Disase;
use App\Models\Paciente;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Livewire\WithPagination;


class PacienteEditCertificado extends Component
{
    use WithPagination;
    use WithFileUploads;
    public $name, $fecha_enfermedad, $tipo_enfermedad, $fecha_finalizacion, $fecha_atencion, $horas_salud, $activo, $tipolicencia_id,
        $disase_id, $patient_disases, $pacientes, $disase, $archivo, $tipodelicencia, $paciente_id, $disases,$paciente;
    public $selectedDisase;
    public $modal = true;
    public $modalEdit = false;
    public $editedDisaseName;

    protected $rules = [
        'name' => 'required',
        'fecha_enfermedad' => 'nullable',
        'fecha_atencion' => 'nullable',
        'tipo_enfermedad' => 'required',
        'disase_id' => 'required',
        'archivo' => 'nullable|file',
        'fecha_finalizacion' => 'nullable',
        'horas_salud' => 'nullable',
        'activo' => 'nullable',
        'tipolicencia_id' => 'nullable',
        'tipodelicencia' => 'nullable'
    ];


    /*public function mount(Paciente $paciente)
    {

        $this->pacientes = $paciente;
        $this->patient_disases = $paciente->disases;
        $this->fecha_enfermedad = $paciente->fecha_enfermedad;
        $this->fecha_atencion = $paciente->fecha_atencion;
        $this->tipo_enfermedad = $paciente->tipo_enfermedad;
        $this->disases=Disase::all();

        $this->pacientes = $paciente;
        $this->patient_disases = $paciente->disases;
        $this->name = $paciente->name;
        //$this->fecha_atencion = $paciente->fecha_atencion;
        //$this->tipo_enfermedad = $paciente->tipo_enfermedad;

        $this->fecha_enfermedad = $paciente->pivot->fecha_enfermedad ?? null;
        $this->tipodelicencia= $paciente->pivot->tipodelicencia?? null;
        $this->fecha_atencion = $paciente->pivot->fecha_atencion ?? null;
        $this->fecha_finalizacion = $paciente->pivot->fecha_finalizacion ?? null;
        $this->horas_salud = $paciente->pivot->horas_salud?? null;
        $this->activo = $paciente->pivot->activo ?? null;
        $this->archivo = $paciente->pivot->archivo ?? null;
        $this->tipo_enfermedad = $paciente->pivot->tipo_enfermedad ?? null;
    }*/
    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente->load('disases');
        $this->disases = Disase::all();
    }





    public function editModalDisase($disaseId)
{
   // $this->emit('editDiseaseModal', $disaseId);
    //$disase = $this->pacientes->disases()->where('disases.id', $disaseId)->first();
    $data = $this->validate();

    // Encuentra el modelo correcto en la colección de disases
    $disase = $this->paciente->disases->where('id', $this->disase_id)->first();

    if ($disase) {
        $this->name = $disase->name;
        $this->editedDisaseName = $disase->name;
        $this->disase_id = $disase->id;
        $this->fecha_enfermedad = $disase->pivot->fecha_enfermedad ?? null;
        $this->tipodelicencia= $disase->pivot->tipodelicencia?? null;
        $this->fecha_atencion = $disase->pivot->fecha_atencion ?? null;
        $this->fecha_finalizacion = $disase->pivot->fecha_finalizacion ?? null;
        $this->horas_salud = $disase->pivot->horas_salud?? null;
        $this->activo = $disase->pivot->activo ?? null;
        $this->archivo = $disase->pivot->archivo ?? null;
        $this->tipo_enfermedad = $disase->pivot->tipo_enfermedad ?? null;
        $this->modal = true;
    }
}






    public function editDisase()
    {
        $data = $this->validate();
        $disase = $this->pacientes->disases()->where('disases.id', $this->disase_id)->first();

        if ($disase) {
            $directoryPath = "public/archivos_disases/paciente_{$this->pacientes->id}";

            if (isset($data['archivo'])) {
                $archivoPath = $data['archivo']->storeAs($directoryPath, $data['archivo']->getClientOriginalName());
            } else {
                $archivoPath = $disase->pivot->archivo;
            }

            $disase->pivot->update([
                'fecha_enfermedad' => $data['fecha_enfermedad'],
                'fecha_atencion' => $data['fecha_atencion'],
                'tipo_enfermedad' => $data['tipo_enfermedad'],
                'archivo' => $archivoPath,
                'fecha_finalizacion' => $data['fecha_finalizacion'],
                'horas_salud' => $data['horas_salud'],
                'activo' => isset($data['activo']) ? $data['activo'] : true,
                'tipodelicencia' => $data['tipodelicencia']
            ]);

            $disase->name = $this->editedDisaseName;
            $disase->slug = Str::slug($this->editedDisaseName);
            $disase->save();

            // $this->modal = false;
            $this->reset([
                'name',
                'editedDisaseName',
                'fecha_enfermedad',
                'tipo_enfermedad',
                'fecha_atencion',
                'fecha_finalizacion',
                'horas_salud',
                'tipolicencia_id',
                'tipodelicencia',
                'activo',
                'archivo',
                'search'
            ]);
            $this->patient_disases = $this->pacientes->disases()->get();
            $this->resetValidation();
            $this->render();
        }
    }

    public function render()
    {
        return view('livewire.paciente.paciente-edit-certificado', [
            'disases' => $this->disases,
            'paciente' => $this->paciente,
        ]);
    }
}
