<?php

namespace App\Livewire\Stats;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class PostulantesStats extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public array $jerarquia_ids = [];
    public array $estado_ids = [];
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

    /** Consulta base: join a pacientes para excluir soft-deleted y traer nombre/jerarquía */
    protected function baseQuery()
    {
        return DB::table('entrevistas as e')
            ->join('pacientes as p', 'p.id', '=', 'e.paciente_id')
            ->whereNull('p.deleted_at') // 👈 oculta pacientes eliminados (soft delete)
            ->select(
                'e.id',
                'e.paciente_id',
                'e.estado_entrevista_id',
                DB::raw('COALESCE(e.fecha, e.created_at) as fecha_ref'),
                'p.apellido_nombre',
                'p.jerarquia_id'
            )
            // filtros
            ->when(!empty($this->jerarquia_ids), fn($q) =>
                $q->whereIn('p.jerarquia_id', $this->jerarquia_ids)
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

      // Totales por estado con los mismos filtros y exclusión de soft-deleted
        $totalesPorEstado = DB::table('entrevistas as e')
            ->join('pacientes as p', 'p.id', '=', 'e.paciente_id')
            ->whereNull('p.deleted_at')
            ->when(!empty($this->jerarquia_ids), fn($q) =>
                $q->whereIn('p.jerarquia_id', $this->jerarquia_ids)
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
            ->select('e.estado_entrevista_id', DB::raw('COUNT(*) as total')) // 👈 alias "total"
            ->groupBy('e.estado_entrevista_id')
            ->pluck('total', 'e.estado_entrevista_id'); // 👈 pluck por alias


        // Catálogos / maps
        $jerarquias    = DB::table('jerarquias')->select('id','name')->orderBy('name')->get();
        $estados       = DB::table('estado_entrevistas')->select('id','name')->orderBy('id')->get();
        $mapJerarquias = $jerarquias->pluck('name','id');
        $mapEstados    = $estados->pluck('name','id');

        return view('livewire.stats.postulantes-stats', [
            'rows'             => $rows,
            'totalesPorEstado' => $totalesPorEstado,
            'jerarquias'       => $jerarquias,
            'estados'          => $estados,
            'mapJerarquias'    => $mapJerarquias,
            'mapEstados'       => $mapEstados,
        ])->layout('layouts.app');
    }
}
