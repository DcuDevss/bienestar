<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\FichaKinesiologica;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class ListaPlanillas extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 8;
    public $statusFilter = ''; // 🟢 nuevo filtro

    // Reset cuando cambian los filtros
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function render()
    {
        Log::info('⚡ Render ListaPlanillas', [
            'search' => $this->search,
            'status' => $this->statusFilter,
            'perPage' => $this->perPage
        ]);

        // Subquery: última planilla por paciente
        $subQuery = FichaKinesiologica::select(DB::raw('MAX(id) as last_id'))
            ->groupBy('paciente_id');

        // Query principal
        $query = FichaKinesiologica::with('paciente.jerarquias', 'paciente.sesiones')
            ->joinSub($subQuery, 'last', function ($join) {
                $join->on('fichas_kinesiologicas.id', '=', 'last.last_id');
            })
            ->orderBy('created_at', 'desc');

        // 🔍 FILTRO DE BÚSQUEDA
        if ($this->search) {
            $search = strtolower($this->search);

            $query->whereHas('paciente', function ($q) use ($search) {
                $q->whereRaw('LOWER(apellido_nombre) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('jerarquias', function ($j) use ($search) {
                        $j->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
            });
        }

        // 🟢 FILTRO DE ESTADO DE SESIÓN
        if ($this->statusFilter === 'sin_registro') {
            // Pacientes sin sesiones
            $query->whereDoesntHave('paciente.sesiones');
        }

        if ($this->statusFilter === 'activa') {
            // Última sesión con firma_paciente_digital = 0
            $query->whereHas('paciente.sesiones', function ($q) {
                $q->latest('id')->limit(1);
            })
                ->whereHas('paciente.sesiones', function ($q) {
                    $q->where('firma_paciente_digital', 0);
                });
        }

        if ($this->statusFilter === 'inactiva') {
            // Última sesión con firma_paciente_digital = 1
            $query->whereHas('paciente.sesiones', function ($q) {
                $q->latest('id')->limit(1);
            })
                ->whereHas('paciente.sesiones', function ($q) {
                    $q->where('firma_paciente_digital', 1);
                });
        }

        // 🟦 PAGINAR
        $planillas = $query->paginate($this->perPage);

        return view('livewire.kinesiologia.lista-planillas', [
            'planillas' => $planillas
        ])->layout('layouts.app');
    }
}
