<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Paciente;
use App\Models\Jerarquia;
use App\Models\EstadoEntrevista;
use App\Models\Ciudade;
use App\Models\Tipolicencia;
use Carbon\Carbon

class PrintReportsController extends Controller
{
    public function licencias(Request $req)
    {
        $pivot  = 'disase_paciente';
        $pacTbl = 'pacientes';

        // Arrays de filtros múltiples
        $tipolicenciaIds = (array) $req->input('tipolicencia_ids', []);
        $ciudadIds       = (array) $req->input('ciudad_ids', []);

        // 🧩 1️⃣ — DETALLE (PACIENTES)
        $rowsBase = DB::table("$pivot as dp")
            ->join("$pacTbl as p", 'p.id', '=', 'dp.paciente_id')
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

        // 🧮 2️⃣ — TOTALES POR TIPO DE LICENCIA
        $totales = DB::table("$pivot as dp")
            ->join("$pacTbl as p", 'p.id', '=', 'dp.paciente_id')
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

        // 🖨️ Render de la vista PDF
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
        // 1) Normalizar filtros (acepta arrays o "1,2,3")
        $norm = function ($val) {
            if (is_array($val)) return array_values(array_filter($val, fn($v)=>$v!=='' && $v!==null));
            if (is_string($val) && trim($val)!=='') return array_values(array_filter(explode(',', $val)));
            return [];
        };
        $jerarquiaIds = $norm($req->input('jerarquia_ids', []));
        $estadoIds    = $norm($req->input('estado_ids', []));

        $desde = $req->input('desde');
        $hasta = $req->input('hasta');

        // 2) Traer filas desde ENTREVISTAS (sin joins)
        $q = DB::table('entrevistas as e')
            ->select(
                'e.paciente_id',
                'e.estado_entrevista_id',
                DB::raw('DATE(e.created_at) as fecha_ref')
            )
            ->when($desde, fn($qq) => $qq->whereDate('e.created_at', '>=', $desde))
            ->when($hasta, fn($qq) => $qq->whereDate('e.created_at', '<=', $hasta))
            ->when(!empty($estadoIds), fn($qq) => $qq->whereIn('e.estado_entrevista_id', $estadoIds))
            ->orderBy('e.created_at', 'desc');

        $rows = $q->get(); // para imprimir, sin paginar

        // 3) Mapas en PHP (para mostrar nombres y filtrar por jerarquía sin joins)
        $mapPacientes        = Paciente::pluck('apellido_nombre', 'id');     // id => nombre
        $mapPacienteJerarId  = Paciente::pluck('jerarquia_id', 'id');        // id => jerarquia_id
        $mapJerarquias       = Jerarquia::pluck('name', 'id');               // id => nombre jerarquía
        $mapEstados          = EstadoEntrevista::pluck('name', 'id');        // id => nombre estado

        // 4) Filtro por jerarquías (en colección)
        if (!empty($jerarquiaIds)) {
            $allowed = array_flip($jerarquiaIds);
            $rows = $rows->filter(function($r) use ($mapPacienteJerarId, $allowed) {
                $jid = $mapPacienteJerarId[$r->paciente_id] ?? null;
                return $jid !== null && isset($allowed[$jid]);
            })->values();
        }

        // 5) Totales por estado (para cards y/o pie)
        $totalesPorEstado = $rows->groupBy('estado_entrevista_id')
                                 ->map->count()
                                 ->toArray();

        // 6) Texto amigable de filtros
        $jerTxt = !empty($jerarquiaIds)
                    ? $mapJerarquias->only($jerarquiaIds)->implode(', ')
                    : 'Todas';
        $estTxt = !empty($estadoIds)
                    ? $mapEstados->only($estadoIds)->implode(', ')
                    : 'Todos';
        $desdeTxt = $desde ? Carbon::parse($desde)->format('d-m-Y') : '—';
        $hastaTxt = $hasta ? Carbon::parse($hasta)->format('d-m-Y') : '—';

        // 7) Render de la vista PDF (sin “undefined property”)
        return view('prints.postulantes', [
            'rows'              => $rows,
            'totalesPorEstado'  => $totalesPorEstado,
            'mapPacientes'      => $mapPacientes,
            'mapPacienteJerarId'=> $mapPacienteJerarId,
            'mapJerarquias'     => $mapJerarquias,
            'mapEstados'        => $mapEstados,
            'filtrosTxt'        => [
                'jerarquias' => $jerTxt,
                'estados'    => $estTxt,
                'desde'      => $desdeTxt,
                'hasta'      => $hastaTxt,
            ],
        ]);
    }
}
