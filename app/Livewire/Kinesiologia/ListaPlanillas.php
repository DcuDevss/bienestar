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

    // Resetear paginación al actualizar búsqueda
    public function updatingSearch()
    {
        $this->resetPage();
        Log::info("🔄 Reset page triggered because search is being updated to '{$this->search}'");
    }

    public function render()
    {
        Log::info('⚡ Render ListaPlanillas iniciado', [
            'search' => $this->search,
            'perPage' => $this->perPage
        ]);

        // Subquery: última planilla por paciente
        $subQuery = FichaKinesiologica::select(DB::raw('MAX(id) as last_id'))
            ->groupBy('paciente_id');

        // Query principal: unir con la tabla para traer datos completos
        $query = FichaKinesiologica::with('paciente.jerarquias')
            ->joinSub($subQuery, 'last', function ($join) {
                $join->on('fichas_kinesiologicas.id', '=', 'last.last_id');
            })
            ->orderBy('created_at', 'desc');

        // Filtro de búsqueda por nombre o jerarquía
        if ($this->search) {
            $search = strtolower($this->search);
            $query->whereHas('paciente', function ($q) use ($search) {
                $q->whereRaw('LOWER(apellido_nombre) LIKE ?', ["%{$search}%"])
                    ->orWhereHas('jerarquias', function ($j) use ($search) {
                        $j->whereRaw('LOWER(name) LIKE ?', ["%{$search}%"]);
                    });
            });
            Log::info('🔍 Aplicando filtro de búsqueda', ['search' => $this->search]);
        }

        // Paginar resultados
        $planillas = $query->paginate($this->perPage);

        Log::info('✅ Planillas filtradas y paginadas', [
            'search' => $this->search,
            'count' => $planillas->count(),
            'total' => $planillas->total(),
            'perPage' => $planillas->perPage(),
            'currentPage' => $planillas->currentPage()
        ]);

        foreach ($planillas as $planilla) {
            Log::info('📌 Planilla', [
                'planilla_id' => $planilla->id,
                'paciente_id' => $planilla->paciente_id,
                'nombre' => $planilla->paciente?->apellido_nombre,
                'jerarquia' => $planilla->paciente?->jerarquias?->name ?? 'N/D',
                'created_at' => $planilla->created_at->toDateTimeString()
            ]);
        }

        return view('livewire.kinesiologia.lista-planillas', [
            'planillas' => $planillas
        ])->layout('layouts.app');
    }
}
