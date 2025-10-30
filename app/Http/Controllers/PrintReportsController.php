<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ciudade;
use App\Models\Tipolicencia;

class PrintReportsController extends Controller
{
    public function licencias(Request $req)
    {
        $pivot  = 'disase_paciente';
        $pacTbl = 'pacientes';

        // Obtener arrays de filtros múltiples
        $tipolicenciaIds = (array) $req->input('tipolicencia_ids', []);
        $ciudadIds       = (array) $req->input('ciudad_ids', []);

        // Base query agrupada
        $q = DB::table($pivot)
            ->join($pacTbl, "$pacTbl.id", '=', "$pivot.paciente_id")
            ->select(
                "$pivot.tipolicencia_id",
                "$pacTbl.ciudad_id",
                DB::raw('COUNT(*) as total')
            )
            // Filtros múltiples
            ->when(!empty($tipolicenciaIds), fn($qq) =>
                $qq->whereIn("$pivot.tipolicencia_id", $tipolicenciaIds)
            )
            ->when(!empty($ciudadIds), fn($qq) =>
                $qq->whereIn("$pacTbl.ciudad_id", $ciudadIds)
            )
            // Filtros por fecha
            ->when($req->filled('desde') || $req->filled('hasta'), function ($qq) use ($pivot, $req) {
                $desde = $req->input('desde', '1900-01-01');
                $hasta = $req->input('hasta', '2999-12-31');
                $qq->whereDate("$pivot.fecha_inicio_licencia", '<=', $hasta)
                   ->where(function($w) use ($pivot, $desde) {
                       $w->whereNull("$pivot.fecha_finalizacion_licencia")
                         ->orWhereDate("$pivot.fecha_finalizacion_licencia", '>=', $desde);
                   });
            })
            ->groupBy("$pivot.tipolicencia_id", "$pacTbl.ciudad_id");

        // Obtener resultados
        $rowsBase = $q->get();
        $total    = $rowsBase->sum('total');

        // Mapear nombres
        $mapCiudades      = Ciudade::pluck('nombre', 'id');
        $mapTipolicencias = Tipolicencia::pluck('name', 'id');

        // Decorar filas
        $rows = $rowsBase->map(function ($r) use ($mapCiudades, $mapTipolicencias) {
            $r->ciudad        = $mapCiudades[$r->ciudad_id] ?? 'Sin ciudad';
            $r->tipolicencia  = $mapTipolicencias[$r->tipolicencia_id] ?? 'Sin tipo';
            return $r;
        });

        // Vista PDF/Impresión
        return view('prints.licencias', [
            'rows'    => $rows,
            'total'   => $total,
            'filtros' => [
                'desde'             => $req->desde,
                'hasta'             => $req->hasta,
                'tipolicencia_ids'  => $tipolicenciaIds,
                'ciudad_ids'        => $ciudadIds,
            ],
        ]);
    }
}
