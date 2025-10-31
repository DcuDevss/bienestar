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
}
