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

        // -----------------------------------------------------------------
        // 1. OBTENCIÓN Y VALIDACIÓN DEL LÍMITE DEL USUARIO
        // -----------------------------------------------------------------
        // Obtener el valor de 'limite'. Esto puede ser una cadena vacía ('') si el usuario lo borró.
        $limiteRequest = request()->get('limite');

        // Convertir a entero para la lógica de la consulta (0 si es vacío o nulo).
        $limiteNumerico = (int) $limiteRequest;

        // -----------------------------------------------------------------

        $query = RegistroSesion::where('paciente_id', $paciente->id);

        // -------------------------
        // FILTRO PRINCIPAL
        // -------------------------
        if ($estado === 'activas') {
            $query->where('firma_paciente_digital', 0);
        } elseif ($estado === 'inactivas') {
            $query->where('firma_paciente_digital', 1);
        } elseif ($estado === 'todas') {

            // FILTRO SECUNDARIO (solo si eligió algo en el subestado)
            if ($subestado === 'activas') {
                $query->where('firma_paciente_digital', 0);
            } elseif ($subestado === 'inactivas') {
                $query->where('firma_paciente_digital', 1);
            }
        }

        // -------------------------
        // TOTAL REAL (antes del límite)
        // -------------------------
        // Clonamos la query para obtener el total real antes de aplicar el límite.
        $totalReal = (clone $query)->count();

        // -----------------------------------------------------------------
        // 2. APLICACIÓN CONDICIONAL DEL LÍMITE (La lógica clave para mostrar "todo")
        // -----------------------------------------------------------------
        $query->orderBy('fecha_sesion', 'asc');

        // Aplicar limit() SOLO si $limiteNumerico es un número positivo (> 0).
        if ($limiteNumerico > 0) {
            $query->limit($limiteNumerico);
        }

        $sesiones = $query->get();

        // -----------------------------------------------------------------
        // 3. AJUSTE DE VARIABLES PARA LA VISTA
        // -----------------------------------------------------------------

        // Esta variable se usa para el warning en Blade: @if ($totalReal > $limite)
        // Si el límite no se aplicó (era 0), lo establecemos a Total + 1 para ocultar el warning.
        $limiteParaWarning = ($limiteNumerico <= 0) ? $totalReal + 1 : $limiteNumerico;

        // Esta variable se usa para el campo input. Necesita ser la cadena original ('')
        // para que el campo se muestre vacío si el usuario lo borró (limiteNumerico <= 0).
        $limiteParaInput = ($limiteNumerico <= 0) ? '' : $limiteNumerico;

        // Sobreescribimos la variable $limite para que la vista use $limiteParaWarning en el if.
        $limite = $limiteParaWarning;

        // Usamos una variable clara para el input.
        $limite_input_valor = $limiteParaInput;

        return view('livewire.kinesiologia.sesiones', compact(
            'paciente',
            'sesiones',
            'estado',
            'subestado',
            'limite', // Contiene $totalReal + 1 (ej: 3) para la lógica de advertencia
            'totalReal',
            'limite_input_valor' // Contiene '' (ej: vacío) para el valor del input
        ));
    }
}
