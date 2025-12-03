<?php

namespace App\Http\Controllers\Kinesiologia;

use App\Http\Controllers\Controller;
use App\Models\RegistroSesion;
use App\Models\Paciente;

class SesionPdfController extends Controller
{
    public function pdfSesiones(Paciente $paciente)
    {
        $estado = request()->get('estado', 'activas'); // activas | inactivas | todas
        $subestado = request()->get('subestado');      // solo si estado=todas
        $limite = max((int) request()->get('limite', 10), 10);

        $query = RegistroSesion::where('paciente_id', $paciente->id);

        // -------------------------
        // FILTRO PRINCIPAL
        // -------------------------
        if ($estado === 'activas') {
            $query->where('firma_paciente_digital', 0);
        } elseif ($estado === 'inactivas') {
            $query->where('firma_paciente_digital', 1);
        } elseif ($estado === 'todas') {

            // FILTRO SECUNDARIO (solo si eligió algo)
            if ($subestado === 'activas') {
                $query->where('firma_paciente_digital', 0);
            } elseif ($subestado === 'inactivas') {
                $query->where('firma_paciente_digital', 1);
            }
        }

        // -------------------------
        // TOTAL REAL (antes del límite)
        // -------------------------
        $totalReal = $query->count();

        // -------------------------
        // LÍMITE
        // -------------------------
        if ($estado === 'todas') {
            $sesiones = $query->orderBy('fecha_sesion', 'asc')->get();
        } else {
            $sesiones = $query->orderBy('fecha_sesion', 'asc')
                ->limit($limite)
                ->get();
        }

        return view('livewire.kinesiologia.sesiones', compact(
            'paciente',
            'sesiones',
            'estado',
            'subestado',
            'limite',
            'totalReal'
        ));
    }
}
