<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Jerarquia;
use App\Models\EstadoEntrevista;
use Carbon\Carbon;

class PrintReportsController extends Controller
{
    public function licencias(Request $req)
    {
        $pivot  = 'disase_paciente';
        $pacTbl = 'pacientes';

        $tipolicenciaIds = (array) $req->input('tipolicencia_ids', []);
        $ciudadIds       = (array) $req->input('ciudad_ids', []);

        // 1) Detalle (pacientes)
        $rowsBase = DB::table("$pivot as dp")
            ->join("$pacTbl as p", 'p.id', '=', 'dp.paciente_id')
            ->whereNull('p.deleted_at') // 👈 excluir soft-deleted
            ->leftJoin('tipolicencias as tl', 'tl.id', '=', 'dp.tipolicencia_id')
            ->leftJoin('ciudades as c', 'c.id', '=', 'p.ciudad_id')
            ->select(
                'p.apellido_nombre',
                'p.dni',
                DB::raw('COALESCE(c.nombre, "Sin ciudad") as ciudad'),
                DB::raw('COALESCE(tl.name, "Sin tipo") as tipolicencia'),
                'dp.fecha_inicio_licencia',
                'dp.fecha_finalizacion_licencia'
            )
            ->when(!empty($tipolicenciaIds), fn($q) =>
                $q->whereIn('dp.tipolicencia_id', $tipolicenciaIds)
            )
            ->when(!empty($ciudadIds), fn($q) =>
                $q->whereIn('p.ciudad_id', $ciudadIds)
            )
            ->when($req->filled('desde') || $req->filled('hasta'), function ($q) use ($req) {
                $desde = $req->input('desde', '1900-01-01');
                $hasta = $req->input('hasta', '2999-12-31');
                $q->whereDate('dp.fecha_inicio_licencia', '<=', $hasta)
                  ->where(function($w) use ($desde) {
                      $w->whereNull('dp.fecha_finalizacion_licencia')
                        ->orWhereDate('dp.fecha_finalizacion_licencia', '>=', $desde);
                  });
            })
            ->orderBy('tl.name')
            ->orderBy('p.apellido_nombre')
            ->get();

        // 2) Totales por tipo
        $totales = DB::table("$pivot as dp")
            ->join("$pacTbl as p", 'p.id', '=', 'dp.paciente_id')
            ->whereNull('p.deleted_at') // 👈 excluir soft-deleted
            ->leftJoin('tipolicencias as tl', 'tl.id', '=', 'dp.tipolicencia_id')
            ->select(
                DB::raw('COALESCE(tl.name, "Sin tipo") as tipolicencia'),
                DB::raw('COUNT(*) as total')
            )
            ->when(!empty($tipolicenciaIds), fn($q) =>
                $q->whereIn('dp.tipolicencia_id', $tipolicenciaIds)
            )
            ->when(!empty($ciudadIds), fn($q) =>
                $q->whereIn('p.ciudad_id', $ciudadIds)
            )
            ->when($req->filled('desde') || $req->filled('hasta'), function ($q) use ($req) {
                $desde = $req->input('desde', '1900-01-01');
                $hasta = $req->input('hasta', '2999-12-31');
                $q->whereDate('dp.fecha_inicio_licencia', '<=', $hasta)
                  ->where(function($w) use ($desde) {
                      $w->whereNull('dp.fecha_finalizacion_licencia')
                        ->orWhereDate('dp.fecha_finalizacion_licencia', '>=', $desde);
                  });
            })
            ->groupBy('tl.name')
            ->orderBy('tl.name')
            ->get();

        $totalGeneral = $totales->sum('total');

        return view('prints.licencias', [
            'rows'         => $rowsBase,
            'totales'      => $totales,
            'totalGeneral' => $totalGeneral,
            'filtros'      => [
                'desde'            => $req->desde,
                'hasta'            => $req->hasta,
                'tipolicencia_ids' => $tipolicenciaIds,
                'ciudad_ids'       => $ciudadIds,
            ],
        ]);
    }

    public function postulantes(Request $req)
    {
        // normalizar arrays
        $norm = function ($val) {
            if (is_array($val)) return array_values(array_filter($val, fn($v)=>$v!=='' && $v!==null));
            if (is_string($val) && trim($val)!=='') return array_values(array_filter(explode(',', $val)));
            return [];
        };
        $jerarquiaIds = $norm($req->input('jerarquia_ids', []));
        $estadoIds    = $norm($req->input('estado_ids', []));
        $desde        = $req->input('desde');
        $hasta        = $req->input('hasta');

        // filas base (entrevistas)
        $rows = DB::table('entrevistas as e')
            ->select(
                'e.paciente_id',
                'e.estado_entrevista_id',
                DB::raw('COALESCE(e.fecha, e.created_at) as fecha_ref')
            )
            ->when($desde, fn($q) => $q->whereDate(DB::raw('COALESCE(e.fecha, e.created_at)'), '>=', $desde))
            ->when($hasta, fn($q) => $q->whereDate(DB::raw('COALESCE(e.fecha, e.created_at)'), '<=', $hasta))
            ->when(!empty($estadoIds), fn($q) => $q->whereIn('e.estado_entrevista_id', $estadoIds))
            ->orderBy('fecha_ref', 'desc')
            ->get();

        // Mapas SOLO de pacientes NO eliminados
        $mapPacientes       = Paciente::whereNull('deleted_at')->pluck('apellido_nombre', 'id');
        $mapPacienteJerarId = Paciente::whereNull('deleted_at')->pluck('jerarquia_id', 'id');

        // Filtrar filas para quedarnos solo con pacientes existentes y no eliminados
        $rows = $rows->filter(function($r) use ($mapPacientes) {
            return $mapPacientes->has($r->paciente_id);
        })->values();

        // Filtro por jerarquías (si viene)
        if (!empty($jerarquiaIds)) {
            $allowed = array_flip($jerarquiaIds);
            $rows = $rows->filter(function($r) use ($mapPacienteJerarId, $allowed) {
                $jid = $mapPacienteJerarId[$r->paciente_id] ?? null;
                return $jid !== null && isset($allowed[$jid]);
            })->values();
        }

        // Diccionarios
        $mapJerarquias = Jerarquia::pluck('name', 'id');
        $mapEstados    = EstadoEntrevista::pluck('name', 'id');

        // Totales por estado
        $totalesPorEstado = $rows->groupBy('estado_entrevista_id')
                                 ->map->count()
                                 ->toArray();

        // Descripciones para cabecera
        $jerTxt   = !empty($jerarquiaIds) ? $mapJerarquias->only($jerarquiaIds)->implode(', ') : 'Todas';
        $estTxt   = !empty($estadoIds)    ? $mapEstados->only($estadoIds)->implode(', ')       : 'Todos';
        $desdeTxt = $desde ? Carbon::parse($desde)->format('d-m-Y') : '—';
        $hastaTxt = $hasta ? Carbon::parse($hasta)->format('d-m-Y') : '—';

        return view('prints.postulantes', [
            'rows'               => $rows,
            'totalesPorEstado'   => $totalesPorEstado,
            'mapPacientes'       => $mapPacientes,
            'mapPacienteJerarId' => $mapPacienteJerarId,
            'mapJerarquias'      => $mapJerarquias,
            'mapEstados'         => $mapEstados,
            'filtrosTxt'         => [
                'jerarquias' => $jerTxt,
                'estados'    => $estTxt,
                'desde'      => $desdeTxt,
                'hasta'      => $hastaTxt,
            ],
        ]);
    }
}
