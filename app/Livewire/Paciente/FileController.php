<?php

namespace App\Livewire\Paciente;

use App\Models\Paciente;
use App\Models\PdfHistorial;
use Livewire\Component;
use Livewire\WithFileUploads;

class FileController extends Component
{
    use WithFileUploads;

    public $search = '';
    public $perPage = 5;
    public $sortAsc = true;
    public $sortField = 'name';
    public $pdfhistorialId;
    public $name, $fecha_enfermedad, $detalle_enfermedad2, $fecha_finalizacion, $fecha_atencion2, $horas_reposo2, $activo, $tipolicencia_id,
        $pdfhistorial_id, $patient_enfermedades, $patient, $pdfhistorial, $archivo, $tipodelicencia;

    public $modal = false;
    public $archivos = [];
    public $pacienteId;

    protected $rules = [
        'archivos.*' => 'file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
        'pacienteId' => 'required|exists:pacientes,id',
    ];

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
        $this->patient = $paciente;
        $this->patient_enfermedades = $paciente->enfermedadPacientes;
    }

    public function addNew()
    {
        $this->modal = true;
    }

    public function createFiles()
    {
        $this->validate();

        foreach ($this->archivos as $archivo) {
            $nombreArchivo = $archivo->getClientOriginalName();
            $timestamp = now()->format('Ymd_His');
            $nombreFinal = $timestamp . '_' . $nombreArchivo;

            $ruta = $archivo->storeAs("pdfhistoriales/{$this->pacienteId}", $nombreFinal, 'public');

            PdfHistorial::create([
                'file' => $ruta,
                'paciente_id' => $this->pacienteId,
            ]);
        }

        $this->archivos = [];
        $this->modal = false;

        // ✅ SweetAlert de éxito
        $this->dispatch('swal', title: 'Cargado', text: 'Archivo(s) subido(s) correctamente.', icon: 'success');
    }

    public function render()
    {
        return view('livewire.paciente.file-controller');
    }
}
