<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Paciente;
use App\Models\FichaKinesiologica;
use Illuminate\Support\Facades\Log;

class FichaKinesiologicaIndex extends Component
{
    use WithPagination;

    // 🎨 Usamos Tailwind para mantener coherencia visual
    protected $paginationTheme = 'tailwind';

    public int $paciente_id;
    public $paciente;

    public $fecha = ''; // Filtrar por fecha YYYY-MM-DD

    // 📄 Control de paginación personalizada
    public $perPage = 3; // ← cantidad de resultados por página

    public ?FichaKinesiologica $fichaSeleccionada = null;
    public bool $editMode = false;

    public bool $modalDetalleAbierto = false;
    public ?FichaKinesiologica $fichaParaDetalle = null;

    public bool $modalCampoAbierto = false;
    public string $campoSeleccionadoTitulo = '';
    public string $campoSeleccionadoContenido = '';

    public $camposDetallesAgrupados = [
        'Anamnesis y Antecedentes' => [
            'diagnostico' => 'Diagnóstico',
            'motivo_consulta' => 'Motivo de consulta',
            'posturas_dolorosas' => 'Posturas dolorosas',
            'realiza_actividad_fisica' => 'Realiza actividad física',
            'tipo_actividad' => 'Tipo de actividad',
            'antecedentes_enfermedades' => 'Antecedentes de enfermedades',
            'antecedentes_familiares' => 'Antecedentes familiares',
            'cirugias' => 'Cirugías',
            'traumatismos_accidentes' => 'Traumatismos/Accidentes',
            'tratamientos_previos' => 'Tratamientos previos',
            'estado_salud_general' => 'Estado de salud general',
            'alteracion_peso' => 'Alteración de peso',
            'medicacion_actual' => 'Medicación actual',
            'observaciones_generales_anamnesis' => 'Observaciones generales',
        ],
        'Antecedentes Femeninos' => [
            'menarca' => 'Menarca',
            'menopausia' => 'Menopausia',
            'partos' => 'Partos',
        ],
        'Examen Visceral' => [
            'visceral_palpacion' => 'Palpación',
            'visceral_dermalgias' => 'Dermalgias',
            'visceral_triggers' => 'Triggers',
            'visceral_fijaciones' => 'Fijaciones',
        ],
        'Examen Craneal' => [
            'craneal_forma' => 'Forma',
            'craneal_triggers' => 'Triggers',
            'craneal_fijaciones' => 'Fijaciones',
            'craneal_musculos' => 'Músculos',
        ],
        'Examen Cardiovascular/Otros' => [
            'tension_arterial' => 'Tensión arterial',
            'pulsos' => 'Pulsos',
            'auscultacion' => 'Auscultación',
            'ecg' => 'ECG',
            'ecodoppler' => 'Ecodoppler',
        ],
    ];

    public function mount(Paciente $paciente)
    {
        $this->paciente_id = $paciente->id;
        $this->paciente = $paciente;
        Log::info("FichaKinesiologicaIndex mounted for paciente_id={$paciente->id}");
    }

    // 🔄 Reinicia paginación al cambiar filtros
    public function updatingFecha()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function filtrarPorFecha()
    {
        $this->resetPage();
    }

    // 👁️ Mostrar detalles completos
    public function mostrarDetalles(int $fichaId)
    {
        $this->fichaParaDetalle = FichaKinesiologica::with('doctor')->find($fichaId);

        if ($this->fichaParaDetalle) {
            $this->modalDetalleAbierto = true;
        } else {
            session()->flash('error', 'No se encontró la ficha.');
        }
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalleAbierto = false;
        $this->fichaParaDetalle = null;
    }

    // 📋 Mostrar campo específico
    public function mostrarDetalleCampo(int $fichaId, string $campo, string $titulo)
    {
        $ficha = FichaKinesiologica::find($fichaId);

        if ($ficha && !empty($ficha->$campo)) {
            $this->campoSeleccionadoTitulo = $titulo;
            $this->campoSeleccionadoContenido = $ficha->$campo;
            $this->modalCampoAbierto = true;
        }
    }

    public function cerrarModalCampo()
    {
        $this->modalCampoAbierto = false;
        $this->campoSeleccionadoTitulo = '';
        $this->campoSeleccionadoContenido = '';
    }

    // ✏️ Editar ficha
    public function edit($fichaId)
    {
        $this->fichaSeleccionada = FichaKinesiologica::find($fichaId);
        $this->editMode = (bool) $this->fichaSeleccionada;
    }

    public function cancelEdit()
    {
        $this->fichaSeleccionada = null;
        $this->editMode = false;
    }

    public function update()
    {
        if (!$this->fichaSeleccionada) return;

        $this->validate([
            'fichaSeleccionada.diagnostico' => 'nullable|string',
            'fichaSeleccionada.motivo_consulta' => 'nullable|string',
        ]);

        $this->fichaSeleccionada->save();
        $this->editMode = false;

        session()->flash('success', 'Ficha actualizada correctamente');
    }

    public function render()
    {
        $fichas = FichaKinesiologica::with('doctor')
            ->where('paciente_id', $this->paciente_id)
            ->when($this->fecha, fn($q) => $q->whereDate('created_at', $this->fecha))
            ->orderByDesc('created_at')
            ->paginate($this->perPage); // 👈 ahora depende del select dinámico

        return view('livewire.kinesiologia.ficha-kinesiologica-index', [
            'fichas' => $fichas,
            'paciente' => $this->paciente,
        ])->layout('layouts.app');
    }
}
