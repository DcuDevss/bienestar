<?php

namespace App\Livewire\Stats;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Tipolicencia;
use App\Models\Ciudade;
use Livewire\WithPagination;

class LicenciasStats extends Component
{
    // Filtros
    public $desde;
    public $hasta;

    // NUEVO: multiselección
    public $tipolicencia_ids = [];   // array de ids
    public $ciudad_ids       = [];   // array de ids

    // Compat (si todavía tenés selects simples en algún lado)
    public $tipolicencia_id; // opcional
    public $perPage = 15;
    public $ciudad_id;       // opcional

    public $total = 0;

    use WithPagination;
    protected $paginationTheme = 'tailwind';

    /**
     * Query base con filtros y agrupación
     */
    public function baseQuery()
    {
        return DB::table('disase_paciente as dp')
            ->join('pacientes as p', 'p.id', '=', 'dp.paciente_id')
            ->leftJoin('tipolicencias as tl', 'tl.id', '=', 'dp.tipolicencia_id')
            ->leftJoin('ciudades as c', 'c.id', '=', 'p.ciudad_id')
            ->select(
                'dp.tipolicencia_id',
                'p.ciudad_id',
                DB::raw('COALESCE(tl.name, "Sin tipo") as tipolicencia'),
                DB::raw('COALESCE(c.nombre, "Sin ciudad") as ciudad'),
                DB::raw('COUNT(*) as total')
            )
            // Fecha (usás fecha_presentacion_certificado en este módulo)
            ->when($this->desde, fn($q) =>
                $q->whereDate('dp.fecha_presentacion_certificado', '>=', $this->desde)
            )
            ->when($this->hasta, fn($q) =>
                $q->whereDate('dp.fecha_presentacion_certificado', '<=', $this->hasta)
            )
            // Tipos: soporta array o valor único (compat)
            ->when(!empty($this->tipolicencia_ids), fn($q) =>
                $q->whereIn('dp.tipolicencia_id', $this->tipolicencia_ids)
            )
            ->when(empty($this->tipolicencia_ids) && $this->tipolicencia_id, fn($q) =>
                $q->where('dp.tipolicencia_id', $this->tipolicencia_id)
            )
            // Ciudades: soporta array o valor único (compat)
            ->when(!empty($this->ciudad_ids), fn($q) =>
                $q->whereIn('p.ciudad_id', $this->ciudad_ids)
            )
            ->when(empty($this->ciudad_ids) && $this->ciudad_id, fn($q) =>
                $q->where('p.ciudad_id', $this->ciudad_id)
            )
            ->groupBy('dp.tipolicencia_id', 'p.ciudad_id', 'tl.name', 'c.nombre')
            ->orderBy('tl.name');
    }

   public function render()
{
    $this->tipolicencia_ids = array_filter((array) $this->tipolicencia_ids, fn($v) => $v !== '' && $v !== null);
    $this->ciudad_ids       = array_filter((array) $this->ciudad_ids, fn($v) => $v !== '' && $v !== null);

    $base = $this->baseQuery();

    $rows = (clone $base)->paginate(10); // 10 filas por página

    $this->total = DB::query()->fromSub($base, 't')->sum('total');

    return view('livewire.stats.licencias-stats', [
        'rows'  => $rows, // ahora es un paginator válido
        'total' => $this->total,
        'tipos' => Tipolicencia::select('id', 'name')->orderBy('name')->get(),
        'ciuds' => Ciudade::select('id', 'nombre')->orderBy('nombre')->get(),
    ])->layout('layouts.app');
}

}
