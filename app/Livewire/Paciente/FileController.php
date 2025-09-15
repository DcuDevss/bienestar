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
        'archivos.*' => 'file|mimes:pdf,png,jpg,jpeg,gif|max:10240', // Acepta PDF e imágenes, máximo 10 MB por archivo
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

        // Subir y almacenar los archivos PDF e imágenes
        foreach ($this->archivos as $archivo) {
            // Obtener el nombre original del archivo
            $nombreArchivo = $archivo->getClientOriginalName();

            // Construir la ruta de almacenamiento con el ID del paciente
            $ruta = $archivo->storeAs("pdfhistoriales/{$this->pacienteId}", $nombreArchivo, 'public');

            // Crear un nuevo registro en la base de datos para cada archivo
            Pdfhistorial::create([
                'file' => $ruta,
                'paciente_id' => $this->pacienteId,
            ]);
        }

        // Limpiar el campo de archivos después de la carga exitosa
        $this->archivos = [];
        $this->modal = false;
        session()->flash('message', 'Archivos subidos exitosamente.');
    }

    public function render()
    {
        return view('livewire.paciente.file-controller');
    }
}
