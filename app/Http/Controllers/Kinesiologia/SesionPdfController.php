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

        // -------------------------
        // 1. OBTENCIÓN DEL LÍMITE DEL USUARIO
        // -------------------------
        $limiteRequest = request()->get('limite', '10'); // Puede ser 'todos' o un número.

        if ($limiteRequest === 'todos') {
            // Un número muy grande para simular "sin límite" en la vista, aunque no se aplicará en la query
            $limite = 9999;
            //limite
        } else {
            // Asegura que el límite sea al menos 10 o el valor ingresado por el usuario
            $limite = max((int) $limiteRequest, 0);
        }

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
        // 2. APLICACIÓN CONDICIONAL DEL LÍMITE
        // -------------------------
        $query->orderBy('fecha_sesion', 'asc');

        // Solo aplica limit() si el usuario no eligió 'todos'
        if ($limiteRequest !== 'todos') {
            $query->limit($limite);
        }

        $sesiones = $query->get();


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
