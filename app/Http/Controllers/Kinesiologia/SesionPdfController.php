<?php

namespace App\Http\Controllers\Kinesiologia;

use App\Http\Controllers\Controller;
use App\Models\RegistroSesion;
use App\Models\Paciente;

class SesionPdfController extends Controller
{
    public function pdfSesiones(Paciente $paciente)
    {
        // Obtener filtros desde la URL
        $estado = request()->get('estado', 'activas'); // activas | inactivas | todas
        $limite = request()->get('limite', 10);

        // Filtrar sesiones
        $query = RegistroSesion::where('paciente_id', $paciente->id);

        if ($estado === 'activas') {
            $query->where('firma_paciente_digital', 0);
        } elseif ($estado === 'inactivas') {
            $query->where('firma_paciente_digital', 1);
        }

        $sesiones = $query->orderBy('fecha_sesion', 'asc')
            ->limit($limite)
            ->get();

        // 👉 Mostrar vista normal (sin PDF)
        return view('livewire.kinesiologia.sesiones', compact(
            'paciente',
            'sesiones',
            'estado',
            'limite'
        ));
    }
}
