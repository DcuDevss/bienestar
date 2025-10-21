<?php

namespace App\Livewire\Paciente;

use App\Models\Paciente;
use App\Models\PdfHistorial;
use App\Models\PdfPsiquiatra;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VerHistorial extends Component
{
    public $pacienteId;

    // Props que la vista usa
    public $search = '';
    public $perPage = 10;
    public $page = 1;
    public $items = [];

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
        $this->loadPdfs();
    }

    protected function dir(): string
    {
        // carpeta del paciente actual
        return "pdfhistoriales/{$this->pacienteId}";
    }

    public function loadPdfs()
    {
        $dir = $this->dir(); // "pdfhistoriales/{$this->pacienteId}"

        // --- 1) PDFs en BD: HISTORIAL ---
        $fromHist = Pdfhistorial::where('paciente_id', $this->pacienteId)->get()->map(function ($row) use ($dir) {
            $origName   = basename($row->file);                // nombre "lindo" que guardaste
            $primary    = "{$dir}/{$origName}";
            $path       = Storage::disk('public')->exists($primary) ? $primary : null;

            // si no existe con el nombre "lindo", no lo mostramos
            if (!$path) return null;

            $realBase   = basename($path);                      // nombre real en disco
            return [
                'key'      => mb_strtolower($realBase),         // clave para deduplicar
                'filename' => $realBase,                        // NOMBRE REAL (para el link)
                'display'  => $origName,                        // NOMBRE LINDO (para mostrar)
                'path'     => $path,
                'url'      => Storage::disk('public')->url($path),
                'source'   => 'historial',
                'modified' => $this->lastModifiedSafe($path),
            ];
        })->filter();

        // --- 2) PDFs en BD: PSIQUIATRA ---
        $fromPsiq = PdfPsiquiatra::where('paciente_id', $this->pacienteId)->get()->map(function ($row) use ($dir) {
            // filepath es el path real; si no, reconstruimos con el nombre original
            $path = $row->filepath ?: "{$dir}/".basename($row->filename ?? '');
            if (!$path || !Storage::disk('public')->exists($path)) return null;

            $realBase = basename($path);
            $display  = $row->filename ?: $realBase;

            return [
                'key'      => mb_strtolower($realBase),
                'filename' => $realBase,                        // NOMBRE REAL (para el link)
                'display'  => $display,                         // NOMBRE LINDO (para mostrar)
                'path'     => $path,
                'url'      => Storage::disk('public')->url($path),
                'source'   => 'psiquiatra',
                'modified' => $this->lastModifiedSafe($path),
            ];
        })->filter();

        // --- 3) Filesystem: todo lo que hay en la carpeta del paciente ---
        $fromFs = collect(Storage::disk('public')->files($dir))
            ->filter(fn($p) => \Illuminate\Support\Str::of($p)->lower()->endsWith('.pdf'))
            ->map(function ($p) {
                $realBase = basename($p);
                return [
                    'key'      => mb_strtolower($realBase),
                    'filename' => $realBase,                    // NOMBRE REAL (para el link)
                    'display'  => $realBase,                    // mostrar real si no hay nombre lindo
                    'path'     => $p,
                    'url'      => Storage::disk('public')->url($p),
                    'source'   => 'archivo',
                    'modified' => $this->lastModifiedSafe($p),
                ];
            });

        // --- 4) Merge: PRIORIDAD BD (psiquiatra/historial) y luego completar con FS ---
        $db = $fromHist->concat($fromPsiq)->keyBy('key');
        $fs = $fromFs->reject(fn($i) => $db->has($i['key']))->keyBy('key');

        $this->items = $db->concat($fs)
            ->values()
            ->sortByDesc('modified')
            ->all();
    }


    protected function lastModifiedSafe(string $path): int
    {
        try {
            return Storage::disk('public')->lastModified($path) ?? 0;
        } catch (\Throwable $e) {
            return 0;
        }
    }

    public function updatedSearch()
    {
        $this->page = 1;
    }

    protected function filtered()
    {
        $q = Str::lower(trim($this->search));
        if ($q === '') return collect($this->items);

        return collect($this->items)->filter(function ($it) use ($q) {
            return Str::contains(Str::lower($it['filename']), $q)
                || Str::contains(Str::lower($it['source']), $q);
        });
    }

    public function getItemsPageProperty()
    {
        $data  = $this->filtered()->values();
        $start = ($this->page - 1) * $this->perPage;
        return $data->slice($start, $this->perPage)->values();
    }

    public function getTotalProperty()
    {
        return $this->filtered()->count();
    }

    public function nextPage()
    {
        if ($this->page * $this->perPage < $this->total) {
            $this->page++;
        }
    }

    public function prevPage()
    {
        if ($this->page > 1) {
            $this->page--;
        }
    }

    public function download($path)
    {
        // Siempre resolvemos a la carpeta del paciente para evitar rutas viejas o externas
        $basename = basename($path);
        $realPath = $this->dir() . '/' . $basename;

        $absolute = Storage::disk('public')->path($realPath);
        if (!file_exists($absolute)) {
            session()->flash('error', 'Archivo no encontrado en la carpeta del paciente.');
            return;
        }
        return response()->download($absolute, $basename);
    }

    public function delete($filename)
    {
        // Normalizamos al nombre real dentro de la carpeta del paciente
        $basename = basename($filename);
        $path     = $this->dir() . '/' . $basename;

        // 1) Borrar del filesystem (si existe)
        if (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            \Illuminate\Support\Facades\Storage::disk('public')->delete($path);
        }

        // 2) Borrar registros en BD que apunten a ese archivo
        // Pdfhistorial guarda en 'file' (ruta completa dentro de 'public')
        \App\Models\Pdfhistorial::where('paciente_id', $this->pacienteId)
            ->where('file', 'like', "%/{$basename}")
            ->delete();

        // PdfPsiquiatra puede tener 'filepath' (ruta) o 'filename' (nombre original)
        \App\Models\PdfPsiquiatra::where('paciente_id', $this->pacienteId)
            ->where(function ($q) use ($basename) {
                $q->where('filepath', 'like', "%/{$basename}")
                ->orWhere('filename', $basename);
            })
            ->delete();

        // Recargar la lista combinada
        $this->loadPdfs();

        // Mensaje simple (ya tenés los alerts arriba en la vista)
        session()->flash('message', 'Archivo eliminado correctamente.');
    }

    public function deleteByPath($path)
    {
        // Normalizamos siempre a la carpeta del paciente para evitar rutas extrañas
        $basename = basename($path);
        $realPath = $this->dir() . '/' . $basename; // ej: pdfhistoriales/{id}/{archivo.pdf}

        // Si no existe, avisamos y salimos
        if (!\Storage::disk('public')->exists($realPath)) {
            session()->flash('error', 'Archivo no encontrado o ya eliminado.');
            return;
        }

        // Borro el archivo físico
        \Storage::disk('public')->delete($realPath);

        // Intento borrar filas en ambas tablas si estuvieran
        \App\Models\Pdfhistorial::where('paciente_id', $this->pacienteId)
            ->where(function ($q) use ($realPath, $basename) {
                $q->where('file', $realPath)->orWhere('file', 'like', "%{$basename}");
            })->delete();

        \App\Models\PdfPsiquiatra::where('paciente_id', $this->pacienteId)
            ->where(function ($q) use ($realPath, $basename) {
                $q->where('filepath', $realPath)->orWhere('filepath', 'like', "%{$basename}");
            })->delete();

        // Recargo la lista
        $this->loadPdfs();

        // Mensaje
        session()->flash('message', 'PDF eliminado correctamente.');
    }


    public function render()
    {
        return view('livewire.paciente.ver-historial', [
            'itemsPage' => $this->itemsPage,
            'total'     => $this->total,
            'pacienteId' => $this->pacienteId,
        ])->layout('layouts.app');
    }
}
