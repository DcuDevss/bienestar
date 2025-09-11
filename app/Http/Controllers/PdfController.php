<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfController extends Controller
{
    public function show(Request $request, $filename)
    {
        // Normalizamos por si viene con espacios/acentos
        $filename = urldecode($filename);

        // Evitar traversal o separadores
        if (Str::contains($filename, ['..', '/', '\\'])) {
            abort(404);
        }

        $pid = $request->query('pid'); // id del paciente (opcional)

        $candidates = [];

        // 1) Si viene pid, buscamos solo en esa carpeta
        if ($pid) {
            $candidates[] = "pdfhistoriales/{$pid}/{$filename}";
        } else {
            // 2) Fallback: buscar en todas las carpetas de pacientes
            foreach (Storage::disk('public')->directories('pdfhistoriales') as $dir) {
                $candidates[] = $dir . '/' . $filename; // ej: pdfhistoriales/2/archivo.pdf
            }
        }

        foreach ($candidates as $path) {
            if (Storage::disk('public')->exists($path)) {
                $absolute = Storage::disk('public')->path($path);

                return response()->file($absolute, [
                    'Content-Type'            => 'application/pdf',
                    'Content-Disposition'     => 'inline; filename="'.addslashes($filename).'"',
                    'X-Content-Type-Options'  => 'nosniff',
                ]);
            }
        }

        abort(404);
    }
}
