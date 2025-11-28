<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use App\Models\FichaKinesiologica;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;

class ListaPlanillas extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 8;
    public $statusFilter = '';

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
        Log::info('Render ListaPlanillas');

        // Última planilla por paciente
        $subQuery = FichaKinesiologica::select(DB::raw('MAX(id) as last_id'))
            ->groupBy('paciente_id');

        // Query principal
        $query = FichaKinesiologica::with(['paciente' => function ($q) {
            $q->withTrashed();
        }, 'paciente.jerarquias'])
            ->joinSub($subQuery, 'last', function ($join) {
                $join->on('fichas_kinesiologicas.id', '=', 'last.last_id');
            })
            ->select('fichas_kinesiologicas.*')
            ->orderBy('fichas_kinesiologicas.created_at', 'desc');

        // 🔍 Buscador
        if (!empty($this->search)) {
            $s = mb_strtolower($this->search);

            $query->whereHas('paciente', function ($q) use ($s) {
                $q->whereRaw('LOWER(apellido_nombre) LIKE ?', ["%{$s}%"])
                    ->orWhereHas('jerarquias', function ($j) use ($s) {
                        $j->whereRaw('LOWER(name) LIKE ?', ["%{$s}%"]);
                    });
            });
        }

        $status = $this->statusFilter;

        // ---------------------------
        //   ✔ PACIENTE ELIMINADO
        // ---------------------------
        if ($status === 'eliminado') {
            $query->whereHas('paciente', fn($q) => $q->onlyTrashed());
        }

        // ---------------------------
        //   ✔ SIN REGISTRO
        // ---------------------------
        if ($status === 'sin_registro') {

            $query->whereRaw('NOT EXISTS (
                SELECT 1 FROM registro_sesiones rs 
                WHERE rs.paciente_id = fichas_kinesiologicas.paciente_id
            )');
        }

        // ---------------------------
        //   ✔ ACTIVA / INACTIVA
        // ---------------------------
        if ($status === 'activa' || $status === 'inactiva') {

            $firmaValue = $status === 'activa' ? 0 : 1;

            // Filtrar por la última sesión EXACTA
            $query->whereRaw('EXISTS (
                SELECT 1 
                FROM registro_sesiones rs
                WHERE rs.paciente_id = fichas_kinesiologicas.paciente_id
                  AND rs.id = (
                      SELECT MAX(id) 
                      FROM registro_sesiones 
                      WHERE paciente_id = fichas_kinesiologicas.paciente_id
                  )
                  AND rs.firma_paciente_digital = ?
            )', [$firmaValue])

                // NO mostrar pacientes eliminados
                ->whereDoesntHave('paciente', fn($q) => $q->onlyTrashed());
        }

        // Resultado final
        $planillas = $query->paginate($this->perPage);

        return view('livewire.kinesiologia.lista-planillas', [
            'planillas' => $planillas
        ])->layout('layouts.app');
    }
}
