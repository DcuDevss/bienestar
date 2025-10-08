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
        $disase_id, $patient_disases, $disase, $archivo, $tipodelicencia, $paciente_id, $disases, $paciente;
    public $selectedDisase;
    public $modal = true;
    public $modalEdit = false;
    public $editedDisaseName;
    public $certificado_id;

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

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente->load('disases');
        $this->disases = Disase::all();
        $this->patient_disases = $this->paciente->disases; // inicializa los certificados
    }

    public function editModalCertificado($certificadoId)
    {
        $this->certificado_id = $certificadoId;

        $certificado = \DB::table('paciente_disase')
            ->where('id', $this->certificado_id)
            ->where('paciente_id', $this->paciente->id)
            ->first();

        if ($certificado) {
            $this->disase_id = $certificado->disase_id;
            $this->name = Disase::find($certificado->disase_id)->name ?? '';
            $this->fecha_enfermedad = $certificado->fecha_enfermedad;
            $this->fecha_atencion = $certificado->fecha_atencion;
            $this->tipo_enfermedad = $certificado->tipo_enfermedad;
            $this->fecha_finalizacion = $certificado->fecha_finalizacion;
            $this->horas_salud = $certificado->horas_salud;
            $this->activo = $certificado->activo;
            $this->tipodelicencia = $certificado->tipodelicencia;
            $this->archivo = $certificado->archivo;

            $this->modal = true;
        } else {
            session()->flash('error', 'Certificado no encontrado');
        }
    }

    public function editModalDisase($disaseId)
    {
        // Validar para evitar errores
        $this->validate();

        $disase = $this->paciente->disases->where('id', $disaseId)->first();

        if ($disase) {
            $this->name = $disase->name;
            $this->editedDisaseName = $disase->name;
            $this->disase_id = $disase->id;
            $this->fecha_enfermedad = $disase->pivot->fecha_enfermedad ?? null;
            $this->tipodelicencia = $disase->pivot->tipodelicencia ?? null;
            $this->fecha_atencion = $disase->pivot->fecha_atencion ?? null;
            $this->fecha_finalizacion = $disase->pivot->fecha_finalizacion ?? null;
            $this->horas_salud = $disase->pivot->horas_salud ?? null;
            $this->activo = $disase->pivot->activo ?? null;
            $this->archivo = $disase->pivot->archivo ?? null;
            $this->tipo_enfermedad = $disase->pivot->tipo_enfermedad ?? null;
            $this->modal = true;
        }
    }

    public function editDisase()
    {
        $data = $this->validate();

        // Ruta para guardar archivo
        $directoryPath = "public/archivos_disases/paciente_{$this->paciente->id}";

        if (isset($data['archivo'])) {
            $archivoPath = $data['archivo']->storeAs($directoryPath, $data['archivo']->getClientOriginalName());
        } else {
            // Si no hay nuevo archivo, conservar el archivo previo
            $certificado = \DB::table('paciente_disase')
                ->where('id', $this->certificado_id)
                ->where('paciente_id', $this->paciente->id)
                ->first();

            $archivoPath = $certificado ? $certificado->archivo : null;
        }

        // Actualizar solo el registro del certificado indicado
        \DB::table('paciente_disase')
            ->where('id', $this->certificado_id)
            ->where('paciente_id', $this->paciente->id)
            ->update([
                'fecha_enfermedad' => $data['fecha_enfermedad'],
                'fecha_atencion' => $data['fecha_atencion'],
                'tipo_enfermedad' => $data['tipo_enfermedad'],
                'archivo' => $archivoPath,
                'fecha_finalizacion' => $data['fecha_finalizacion'],
                'horas_salud' => $data['horas_salud'],
                'activo' => $data['activo'] ?? true,
                'tipodelicencia' => $data['tipodelicencia']
            ]);

        // Opcional: actualizar nombre y slug en tabla disase
        $disase = Disase::find($this->disase_id);
        if ($disase && $this->editedDisaseName) {
            $disase->name = $this->editedDisaseName;
            $disase->slug = Str::slug($this->editedDisaseName);
            $disase->save();
        }

        // Refrescar certificados del paciente
        $this->patient_disases = $this->paciente->disases()->get();

        // Limpiar variables
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
            'certificado_id',
            'search'
        ]);

        $this->resetValidation();

        $this->modal = false;
    }

    public function render()
    {
        return view('livewire.paciente.paciente-edit-certificado', [
            'disases' => $this->disases,
            'paciente' => $this->paciente,
        ]);
    }
}
