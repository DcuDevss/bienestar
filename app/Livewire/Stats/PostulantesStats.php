<?php

namespace App\Livewire\Stats;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PostulantesStats extends Component
{
    use WithPagination;

    public array $jerarquia_ids = [];   // IDs de jerarquías (p.ej. postulante a agente/cadete)
    public array $estado_ids = [];      // IDs de estados (apto/no apto/condicional)
    public ?string $desde = null;
    public ?string $hasta = null;

    protected $queryString = [
        'jerarquia_ids' => ['except' => []],
        'estado_ids'    => ['except' => []],
        'desde'         => ['except' => null],
        'hasta'         => ['except' => null],
    ];

    public function updating($name, $value)
    {
        $this->resetPage();
    }

    protected function baseQuery()
    {
        // Si hay filtro de jerarquías, resolvemos primero los paciente_id que cumplan
        $pacientesFiltrados = null;
        if (!empty($this->jerarquia_ids)) {
            $pacientesFiltrados = DB::table('pacientes')
                ->whereIn('jerarquia_id', $this->jerarquia_ids)
                ->pluck('id'); // colección de ids
        }

        return DB::table('entrevistas as e')
            ->select(
                'e.id',
                'e.paciente_id',
                'e.estado_entrevista_id',
                DB::raw('COALESCE(e.fecha, e.created_at) as fecha_ref')
            )
            ->when($pacientesFiltrados && $pacientesFiltrados->isNotEmpty(), fn($q) =>
                $q->whereIn('e.paciente_id', $pacientesFiltrados)
            )
            ->when(!empty($this->estado_ids), fn($q) =>
                $q->whereIn('e.estado_entrevista_id', $this->estado_ids)
            )
            ->when($this->desde, fn($q) =>
                $q->whereDate(DB::raw('COALESCE(e.fecha, e.created_at)'), '>=', $this->desde)
            )
            ->when($this->hasta, fn($q) =>
                $q->whereDate(DB::raw('COALESCE(e.fecha, e.created_at)'), '<=', $this->hasta)
            )
            ->orderBy('fecha_ref', 'desc');
    }

    public function render()
    {
        $rows = $this->baseQuery()->paginate(15);

        // Totales por estado con los mismos filtros
        $totalesPorEstado = DB::table('entrevistas as e')
            ->select('e.estado_entrevista_id', DB::raw('COUNT(*) as total'))
            ->when(!empty($this->jerarquia_ids), function($q){
                $pids = DB::table('pacientes')->whereIn('jerarquia_id', $this->jerarquia_ids)->pluck('id');
                if ($pids->isNotEmpty()) $q->whereIn('e.paciente_id', $pids);
            })
            ->when(!empty($this->estado_ids), fn($q) =>
                $q->whereIn('e.estado_entrevista_id', $this->estado_ids)
            )
            ->when($this->desde, fn($q) =>
                $q->whereDate(DB::raw('COALESCE(e.fecha, e.created_at)'), '>=', $this->desde)
            )
            ->when($this->hasta, fn($q) =>
                $q->whereDate(DB::raw('COALESCE(e.fecha, e.created_at)'), '<=', $this->hasta)
            )
            ->groupBy('e.estado_entrevista_id')
            ->pluck('total', 'e.estado_entrevista_id');

        // Catálogos
        $jerarquias = DB::table('jerarquias')->select('id','name')->orderBy('name')->get();
        $estados    = DB::table('estado_entrevistas')->select('id','name')->orderBy('id')->get();
        $mapJerarquias = $jerarquias->pluck('name','id');
        $mapEstados    = $estados->pluck('name','id');

        // Mapear paciente -> nombre y paciente -> jerarquia_id para las filas de la página
        $pidsPagina = $rows->pluck('paciente_id')->filter()->unique()->values();
        $mapPacientes       = $pidsPagina->isNotEmpty()
            ? DB::table('pacientes')->whereIn('id', $pidsPagina)->pluck('apellido_nombre','id')
            : collect();
        $mapPacienteJerarId = $pidsPagina->isNotEmpty()
            ? DB::table('pacientes')->whereIn('id', $pidsPagina)->pluck('jerarquia_id','id')
            : collect();

        return view('livewire.stats.postulantes-stats', [
            'rows'               => $rows,
            'totalesPorEstado'   => $totalesPorEstado,
            'jerarquias'         => $jerarquias,
            'estados'            => $estados,
            'mapJerarquias'      => $mapJerarquias,
            'mapEstados'         => $mapEstados,
            'mapPacientes'       => $mapPacientes,
            'mapPacienteJerarId' => $mapPacienteJerarId,
        ])->layout('layouts.app');
    }
}
