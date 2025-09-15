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

    public function render()
    {
        return view('livewire.paciente.ver-historial', [
            'itemsPage' => $this->itemsPage,
            'total'     => $this->total,
            'pacienteId' => $this->pacienteId,
        ])->layout('layouts.app');
    }
}
