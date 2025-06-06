<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Entrevista;
use Livewire\WithPagination;



class PatientEntrevistas extends Component
{
    use WithPagination;

    public $search = '';  // Propiedad para la búsqueda
    public $poseeArmaFilter = null; // null significa sin filtro
    public $poseeArmaFilterDisplay;
    public $recomendacionFilter = null;
    public $recomendacionFilterDisplay = '';
    public $sortBy = 'entrevistas.id'; // Especificamos la tabla en el ORDER BY
    public $sortDir = 'ASC';
    public $perPage = 8;

    // Resetea la página cuando se actualiza el término de búsqueda
    public function updatedSearch()
    {
        $this->resetPage(); // Resetea la paginación cuando cambia la búsqueda
    }

    // Cambia la dirección de la ordenación
    public function setSortBy($sortByField)
    {
        if ($this->sortBy === $sortByField) {
            $this->sortDir = ($this->sortDir == "ASC") ? 'DESC' : "ASC";
            return;
        }

        $this->sortBy = 'entrevistas.' . $sortByField;
        $this->sortDir = 'DESC';
    }

    // Convierte las entradas 'Sí' y 'No' en valores booleanos
    public function updatedPoseeArmaFilterDisplay()
    {
        $this->poseeArmaFilter = match (strtolower(trim($this->poseeArmaFilterDisplay))) {
            'sí', 'si' => 1,
            'no' => 0,
            default => null,
        };

        $this->resetPage(); // Restablece la paginación cuando cambia el filtro
    }

    public function updatedRecomendacionFilterDisplay()
    {
        $this->recomendacionFilter = match (strtolower(trim($this->recomendacionFilterDisplay))) {
            'sí', 'si' => 1,
            'no' => 0,
            default => null,
        };

        $this->resetPage();
    }

    public function mount()
    {

        // Inicializa el valor de la propiedad display en 'sí' o 'no' basado en el valor actual de poseeArmaFiltery el segungdo recomendacionFilter
        $this->poseeArmaFilterDisplay = $this->poseeArmaFilter === 1 ? 'sí' : ($this->poseeArmaFilter === 0 ? 'no' : '');
        $this->recomendacionFilterDisplay = $this->recomendacionFilter === 1 ? 'sí' : ($this->recomendacionFilter === 0 ? 'no' : '');

    }


    public function render()
    {
        $searchLower = strtolower($this->search);

        // Subconsulta para obtener la última entrevista de cada paciente
        $lastEntrevistaSubquery = Entrevista::query()
            ->selectRaw('paciente_id, MAX(created_at) as latest_created_at')
            ->groupBy('paciente_id');

        // Consulta principal para obtener las entrevistas con los filtros aplicados
        $entrevistas = Entrevista::query()
            ->select( 'entrevistas.*','pacientes.apellido_nombre', 'pacientes.estado_id', 'pacientes.id as paciente_id', 'estados.name as estado_nombre')
            ->joinSub($lastEntrevistaSubquery, 'last_entrevista', function ($join) {
                $join->on('entrevistas.paciente_id', '=', 'last_entrevista.paciente_id')
                    ->whereColumn('entrevistas.created_at', '=', 'last_entrevista.latest_created_at');
            })
            ->leftJoin('tipo_entrevistas', 'entrevistas.tipo_entrevista_id', '=', 'tipo_entrevistas.id')
            ->leftJoin('estado_entrevistas', 'entrevistas.estado_entrevista_id', '=', 'estado_entrevistas.id')
            ->leftJoin('pacientes', 'entrevistas.paciente_id', '=', 'pacientes.id') // Unir la tabla de pacientes
            ->leftJoin('estados', 'pacientes.estado_id', '=', 'estados.id')
            ->when($this->search, function ($query) use ($searchLower) {
                $query->whereRaw('LOWER(entrevistas.created_at) LIKE ?', ['%' . $searchLower . '%'])
                    ->orWhereHas('tipoEntrevista', function ($query) use ($searchLower) {
                        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchLower . '%']);
                    })
                    ->orWhereHas('estadoEntrevista', function ($query) use ($searchLower) {
                        $query->whereRaw('LOWER(name) LIKE ?', ['%' . $searchLower . '%']);
                    })
                    ->orWhere('entrevistas.paciente_id', 'LIKE', '%' . $searchLower . '%')  // Buscar por paciente_id
                    ->orWhereRaw('LOWER(pacientes.apellido_nombre) LIKE ?', ['%' . $searchLower . '%']) // Buscar por apellido_nombre
                    ->orWhereHas('paciente.jerarquias', function ($query) use ($searchLower) {
                        $query->whereRaw('LOWER(jerarquias.name) LIKE ?', ['%' . $searchLower . '%']); // Buscar por jerarquias->name
                    });
            })
            ->when($this->poseeArmaFilter !== null, function ($query) {
                // Si el valor de poseeArmaFilter es 0 (no), buscar tanto 0 como null
                if ($this->poseeArmaFilter == 0) {
                    $query->where(function ($query) {
                        $query->where('entrevistas.posee_arma', '=', 0)
                            ->orWhereNull('entrevistas.posee_arma');
                    });
                } else {
                    // Si el valor de poseeArmaFilter es 1 (sí), solo filtrar los registros con posee_arma = 1
                    $query->where('entrevistas.posee_arma', '=', 1);
                }
            })
            ->when($this->recomendacionFilter !== null, function ($query) {
                if ($this->recomendacionFilter == 0) {
                    $query->where(function ($query) {
                        $query->where('entrevistas.recomendacion', '=', 0)
                            ->orWhereNull('entrevistas.recomendacion');
                    });
                } else {
                    $query->where('entrevistas.recomendacion', '=', 1);
                }
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        $noResults = $entrevistas->isEmpty();

        return view('livewire.patient.patient-entrevistas', compact('entrevistas'))->layout('layouts.app');
    }

}
