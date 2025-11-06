<?php

namespace App\Livewire\Stats;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Models\Tipolicencia;
use App\Models\Ciudade;

class LicenciasStats extends Component
{
    use WithPagination;

    public $desde, $hasta;
    public $tipolicencia_ids = [];   // múltiples tipos (checkbox)
    public $ciudad_ids = [];         // múltiples ciudades (checkbox)

    protected $paginationTheme = 'tailwind';

    /** Fila a fila (pacientes) */
    protected function baseRowsQuery()
    {
        return DB::table('disase_paciente as dp')
            ->join('pacientes as p', 'p.id', '=', 'dp.paciente_id')
            ->whereNull('p.deleted_at') // 👈 filtra pacientes eliminados
            ->leftJoin('tipolicencias as tl', 'tl.id', '=', 'dp.tipolicencia_id')
            ->leftJoin('ciudades as c', 'c.id', '=', 'p.ciudad_id')
            ->select(
                'p.apellido_nombre',
                'p.dni',
                'p.ciudad_id',
                'dp.tipolicencia_id',
                'dp.fecha_inicio_licencia',
                'dp.fecha_finalizacion_licencia',
                DB::raw('COALESCE(tl.name, "Sin tipo") as tipolicencia'),
                DB::raw('COALESCE(c.nombre, "Sin ciudad") as ciudad')
            )
            // ventana de fechas (intersección con la licencia)
            ->when($this->desde || $this->hasta, function($q) {
                $desde = $this->desde ?: '1900-01-01';
                $hasta = $this->hasta ?: '2999-12-31';
                $q->whereDate('dp.fecha_inicio_licencia', '<=', $hasta)
                  ->where(function($w) use ($desde) {
                      $w->whereNull('dp.fecha_finalizacion_licencia')
                        ->orWhereDate('dp.fecha_finalizacion_licencia', '>=', $desde);
                  });
            })
            // filtros múltiples
            ->when(!empty($this->tipolicencia_ids), fn($q) =>
                $q->whereIn('dp.tipolicencia_id', $this->tipolicencia_ids)
            )
            ->when(!empty($this->ciudad_ids), fn($q) =>
                $q->whereIn('p.ciudad_id', $this->ciudad_ids)
            )
            ->orderBy('tl.name')
            ->orderBy('p.apellido_nombre');
    }

    /** Totales por tipo (mismos filtros, pero agregados) */
    protected function baseTotalsQuery()
    {
        return DB::table('disase_paciente as dp')
            ->join('pacientes as p', 'p.id', '=', 'dp.paciente_id')
            ->leftJoin('tipolicencias as tl', 'tl.id', '=', 'dp.tipolicencia_id')
            ->select(
                'dp.tipolicencia_id',
                DB::raw('COALESCE(tl.name, "Sin tipo") as tipolicencia'),
                DB::raw('COUNT(*) as total')
            )
            ->when($this->desde || $this->hasta, function($q) {
                $desde = $this->desde ?: '1900-01-01';
                $hasta = $this->hasta ?: '2999-12-31';
                $q->whereDate('dp.fecha_inicio_licencia', '<=', $hasta)
                  ->where(function($w) use ($desde) {
                      $w->whereNull('dp.fecha_finalizacion_licencia')
                        ->orWhereDate('dp.fecha_finalizacion_licencia', '>=', $desde);
                  });
            })
            ->when(!empty($this->tipolicencia_ids), fn($q) =>
                $q->whereIn('dp.tipolicencia_id', $this->tipolicencia_ids)
            )
            ->when(!empty($this->ciudad_ids), fn($q) =>
                $q->whereIn('p.ciudad_id', $this->ciudad_ids)
            )
            ->groupBy('dp.tipolicencia_id', 'tl.name')
            ->orderBy('tl.name');
    }

    public function render()
    {
        // normalizo arrays por si vienen strings
        $this->tipolicencia_ids = array_values(array_filter((array)$this->tipolicencia_ids, fn($v) => $v !== '' && $v !== null));
        $this->ciudad_ids       = array_values(array_filter((array)$this->ciudad_ids, fn($v) => $v !== '' && $v !== null));

        // filas (uno por uno)
        $rows = $this->baseRowsQuery()->paginate(25);

        // totales por tipo
        $totales = $this->baseTotalsQuery()->get();
        $totalGeneral = $totales->sum('total');

        return view('livewire.stats.licencias-stats', [
            'rows'         => $rows,
            'totales'      => $totales,
            'totalGeneral' => $totalGeneral,
            // catálogos para tus filtros existentes
            'tipos'        => Tipolicencia::select('id','name')->orderBy('name')->get(),
            'ciuds'        => Ciudade::select('id','nombre')->orderBy('nombre')->get(),
        ])->layout('layouts.app');
    }
}
