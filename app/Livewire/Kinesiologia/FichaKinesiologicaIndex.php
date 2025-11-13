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

    protected $paginationTheme = 'tailwind';

    public int $paciente_id;
    public $paciente;

    public $fecha = ''; // Filtrar por fecha YYYY-MM-DD

    public ?FichaKinesiologica $fichaSeleccionada = null; // Ficha en edición
    public bool $editMode = false;

    // 🌟 Modal de detalle completo
    public bool $modalDetalleAbierto = false;
    public ?FichaKinesiologica $fichaParaDetalle = null;

    // 🌟 Modal de campo específico
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

    public function updatingFecha()
    {
        $this->resetPage();
        Log::info("Buscando fichas para fecha={$this->fecha}");
    }

    public function filtrarPorFecha()
    {
        $this->resetPage();
        Log::info("Filtrando fichas por fecha={$this->fecha}");
    }

    public function mostrarDetalles(int $fichaId)
    {
        $this->fichaParaDetalle = FichaKinesiologica::with('doctor')->find($fichaId);

        if ($this->fichaParaDetalle) {
            $this->modalDetalleAbierto = true;
            Log::info("👀 Abriendo modal de detalle para ficha_id={$fichaId}");
        } else {
            session()->flash('error', 'No se encontró la ficha para ver detalles.');
            Log::warning("❌ Ficha_id={$fichaId} no encontrada para detalle.");
        }
    }

    public function cerrarModalDetalle()
    {
        $this->modalDetalleAbierto = false;
        $this->fichaParaDetalle = null;
        Log::info("❌ Cerrando modal de detalle.");
    }

    public function mostrarDetalleCampo(int $fichaId, string $campo, string $titulo)
    {
        $ficha = FichaKinesiologica::find($fichaId);

        if ($ficha && !empty($ficha->$campo)) {
            $this->campoSeleccionadoTitulo = $titulo;
            $this->campoSeleccionadoContenido = $ficha->$campo;
            $this->modalCampoAbierto = true;
            Log::info("👀 Abriendo modal para campo: {$titulo} de ficha_id={$fichaId}");
        }
    }

    public function cerrarModalCampo()
    {
        $this->modalCampoAbierto = false;
        $this->campoSeleccionadoTitulo = '';
        $this->campoSeleccionadoContenido = '';
    }

    public function edit($fichaId)
    {
        $this->fichaSeleccionada = FichaKinesiologica::find($fichaId);
        if ($this->fichaSeleccionada) {
            $this->editMode = true;
            Log::info("✏️ Editando ficha_id={$fichaId} del paciente_id={$this->paciente_id}");
        } else {
            session()->flash('error', 'No se encontró la ficha.');
            Log::warning("❌ Ficha_id={$fichaId} no encontrada para paciente_id={$this->paciente_id}");
        }
    }

    public function cancelEdit()
    {
        $this->fichaSeleccionada = null;
        $this->editMode = false;
        Log::info("❌ Cancelada edición de ficha para paciente_id={$this->paciente_id}");
    }

    public function update()
    {
        if (!$this->fichaSeleccionada) {
            session()->flash('error', 'No hay ficha seleccionada.');
            return;
        }

        $this->validate([
            'fichaSeleccionada.diagnostico' => 'nullable|string',
            'fichaSeleccionada.motivo_consulta' => 'nullable|string',
            'fichaSeleccionada.posturas_dolorosas' => 'nullable|string',
            'fichaSeleccionada.realiza_actividad_fisica' => 'nullable|string',
            'fichaSeleccionada.tipo_actividad' => 'nullable|string',
            'fichaSeleccionada.antecedentes_enfermedades' => 'nullable|string',
            'fichaSeleccionada.antecedentes_familiares' => 'nullable|string',
            'fichaSeleccionada.cirugias' => 'nullable|string',
            'fichaSeleccionada.traumatismos_accidentes' => 'nullable|string',
            'fichaSeleccionada.tratamientos_previos' => 'nullable|string',
        ]);

        $this->fichaSeleccionada->save();
        $this->editMode = false;

        session()->flash('success', 'Ficha actualizada correctamente');
        Log::info("✅ Ficha actualizada: id={$this->fichaSeleccionada->id}");
    }

    public function render()
    {
        $fichas = FichaKinesiologica::with('doctor')
            ->where('paciente_id', $this->paciente_id)
            ->when($this->fecha, fn($q) => $q->whereDate('created_at', $this->fecha))
            ->orderByDesc('created_at')
            ->paginate(3);

        Log::info("📄 Se obtuvieron {$fichas->total()} fichas para paciente_id={$this->paciente_id}");

        return view('livewire.kinesiologia.ficha-kinesiologica-index', [
            'fichas' => $fichas,
            'paciente' => $this->paciente,
        ])->layout('layouts.app');
    }
}
