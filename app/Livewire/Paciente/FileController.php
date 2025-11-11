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
        // 1) Bloquear cuando no hay nada seleccionado
        if (empty($this->archivos) || count($this->archivos) === 0) {
            $this->dispatch('swal', title: 'Sin archivos', text: 'Seleccioná al menos un archivo para subir.', icon: 'error');
            return;
        }

        // 2) Validación coompleta (array + cada ítem)
        $this->validate([
            'archivos'   => 'required|array|min:1',
            'archivos.*' => 'file|mimes:pdf,png,jpg,jpeg,gif|max:10240',
            'pacienteId' => 'required|exists:pacientes,id',
        ]);

        foreach ($this->archivos as $archivo) {
            $nombreOriginal = $archivo->getClientOriginalName();
            $timestamp = now()->format('d-m-Y_H-i-s');

            // sanitizar nombre base y conservar extensión original
            $ext         = $archivo->getClientOriginalExtension();
            $base        = pathinfo($nombreOriginal, PATHINFO_FILENAME);
            $seguro      = \Illuminate\Support\Str::slug($base);
            $nombreFinal = "{$timestamp}_{$seguro}.".strtolower($ext);

            $ruta = $archivo->storeAs("pdfhistoriales/{$this->pacienteId}", $nombreFinal, 'public');

            \App\Models\PdfHistorial::create([
                'file'        => $ruta,
                'paciente_id' => $this->pacienteId,
            ]);
        }

        // limpiar estado UI
        $this->reset('archivos');
        $this->modal = false;

        $this->dispatch('swal', title: 'Cargado', text: 'Archivo(s) subido(s) correctamente.', icon: 'success');
    }


    public function render()
    {
        return view('livewire.paciente.file-controller');
    }
}
