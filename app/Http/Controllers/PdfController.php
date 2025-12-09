<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Helpers\PdfCrypto;

class PdfController extends Controller
{
    /**
     * Mostrar PDF en el navegador desencriptado.
     */
    public function show(Request $request, $filename)
    {
        $filename = urldecode($filename);

        // Evitar path traversal
        if (Str::contains($filename, ['..', '/', '\\'])) {
            abort(404);
        }

        $pid = $request->query('pid'); // paciente id opcional
        $candidates = [];

        // 1) Si hay paciente, buscar solo en su carpeta
        if ($pid) {
            $candidates[] = "pdfhistoriales/{$pid}/{$filename}";
        } else {
            // 2) Buscar en todas las carpetas
            foreach (Storage::disk('public')->directories('pdfhistoriales') as $dir) {
                $candidates[] = $dir . '/' . $filename;
            }
        }

        foreach ($candidates as $path) {
            if (Storage::disk('public')->exists($path)) {
                // Desencriptar en memoria
                $decrypted = PdfCrypto::getDecrypted('public', $path);
                if (!$decrypted) abort(404);

                return response($decrypted, 200)
                    ->header('Content-Type', 'application/pdf')
                    ->header('Content-Disposition', 'inline; filename="' . addslashes($filename) . '"');
            }
        }

        abort(404);
    }

    /**
     * Descargar PDF desencriptado.
     */
    public function download(Request $request, $filename)
    {
        $filename = urldecode($filename);

        if (Str::contains($filename, ['..', '/', '\\'])) {
            abort(404);
        }

        $pid = $request->query('pid'); // paciente id opcional
        $candidates = [];

        if ($pid) {
            $candidates[] = "pdfhistoriales/{$pid}/{$filename}";
        } else {
            foreach (Storage::disk('public')->directories('pdfhistoriales') as $dir) {
                $candidates[] = $dir . '/' . $filename;
            }
        }

        foreach ($candidates as $path) {
            if (Storage::disk('public')->exists($path)) {
                $decrypted = PdfCrypto::getDecrypted('public', $path);
                if (!$decrypted) abort(404);

                return response()->streamDownload(function () use ($decrypted) {
                    echo $decrypted;
                }, $filename, [
                    'Content-Type'   => 'application/pdf',
                    'Content-Length' => strlen($decrypted),
                ]);
            }
        }

        abort(404);
    }
}
