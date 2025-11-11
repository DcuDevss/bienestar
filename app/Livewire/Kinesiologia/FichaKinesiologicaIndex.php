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

    public Paciente $paciente;

    public $fecha = ''; // Filtrar por fecha YYYY-MM-DD

    public ?FichaKinesiologica $fichaSeleccionada = null; // Ficha en edición
    public bool $editMode = false;   // Indica si se está editando

    protected $paginationTheme = 'tailwind';

    // Monta el componente con el paciente
    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
        Log::info("FichaKinesiologicaIndex mounted for paciente_id={$paciente->id}");
    }

    // Resetea la página al cambiar la fecha
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

    // Abrir ficha para edición
    public function edit($fichaId)
    {
        $this->fichaSeleccionada = FichaKinesiologica::find($fichaId);
        if ($this->fichaSeleccionada) {
            $this->editMode = true;
            Log::info("✏️ Editando ficha_id={$fichaId} del paciente_id={$this->paciente->id}");
        } else {
            session()->flash('error', 'No se encontró la ficha.');
            Log::warning("❌ Ficha_id={$fichaId} no encontrada para paciente_id={$this->paciente->id}");
        }
    }

    // Cancelar edición
    public function cancelEdit()
    {
        $this->fichaSeleccionada = null;
        $this->editMode = false;
        Log::info("❌ Cancelada edición de ficha para paciente_id={$this->paciente->id}");
    }

    // Guardar cambios
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
            // Agrega aquí otros campos que tengas en tu ficha
        ]);

        $this->fichaSeleccionada->save();
        $this->editMode = false;

        session()->flash('success', 'Ficha actualizada correctamente');
        Log::info("✅ Ficha actualizada: id={$this->fichaSeleccionada->id}");
    }

    // Renderiza la vista con fichas paginadas
    public function render()
    {
        $fichas = FichaKinesiologica::with('doctor')
            ->where('paciente_id', $this->paciente->id)
            ->when($this->fecha, fn($q) => $q->whereDate('created_at', $this->fecha))
            ->orderByDesc('created_at')
            ->paginate(3);

        Log::info("📄 Se obtuvieron {$fichas->total()} fichas para paciente_id={$this->paciente->id}");

        return view('livewire.kinesiologia.ficha-kinesiologica-index', [
            'fichas' => $fichas,
        ])->layout('layouts.app');
    }
}
