<?php

namespace App\Livewire\Paciente;

use App\Models\Paciente;
use App\Models\PdfHistorial;
use App\Models\PdfPsiquiatra;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class VerHistorial extends Component
{
    public $pacienteId;

    public $search = '';
    public $perPage = 10;
    public $page = 1;
    public $items; // ahora colección

    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
        Log::info("Mount VerHistorial para pacienteId: {$this->pacienteId}");
        $this->loadPdfs();
    }

    protected function dir(): string
    {
        return "pdfhistoriales/{$this->pacienteId}";
    }

    public function loadPdfs()
    {
        $dir = $this->dir();
        Log::info("Cargando PDFs del directorio: {$dir}");

        // PDFs Historial
        $fromHist = PdfHistorial::where('paciente_id', $this->pacienteId)->get()->map(function ($row) use ($dir) {
            $origName = basename($row->file);
            $primary  = "{$dir}/{$origName}";
            if (!Storage::disk('public')->exists($primary)) return null;

            $realBase = basename($primary);
            Log::info("PDF Historial encontrado: {$realBase}");

            return [
                'key'      => mb_strtolower($realBase),
                'filename' => $realBase,
                'display'  => $origName,
                'path'     => $primary,
                'url'      => Storage::disk('public')->url($primary),
                'source'   => 'historial',
                'modified' => $this->lastModifiedSafe($primary),
            ];
        })->filter();

        // PDFs Psiquiatra
        $fromPsiq = PdfPsiquiatra::where('paciente_id', $this->pacienteId)->get()->map(function ($row) use ($dir) {
            $path = $row->filepath ?: "{$dir}/" . basename($row->filename ?? '');
            if (!$path || !Storage::disk('public')->exists($path)) return null;

            $realBase = basename($path);
            $display  = $row->filename ?: $realBase;
            Log::info("PDF Psiquiatra encontrado: {$realBase}");

            return [
                'key'      => mb_strtolower($realBase),
                'filename' => $realBase,
                'display'  => $display,
                'path'     => $path,
                'url'      => Storage::disk('public')->url($path),
                'source'   => 'psiquiatra',
                'modified' => $this->lastModifiedSafe($path),
            ];
        })->filter();

        // PDFs filesystem
        $fromFs = collect(Storage::disk('public')->files($dir))
            ->filter(fn($p) => Str::of($p)->lower()->endsWith('.pdf'))
            ->map(function ($p) {
                $realBase = basename($p);
                Log::info("PDF en filesystem: {$realBase}");
                return [
                    'key'      => mb_strtolower($realBase),
                    'filename' => $realBase,
                    'display'  => $realBase,
                    'path'     => $p,
                    'url'      => Storage::disk('public')->url($p),
                    'source'   => 'archivo',
                    'modified' => $this->lastModifiedSafe($p),
                ];
            });

        // Merge BD + FS
        $db = $fromHist->concat($fromPsiq)->keyBy('key');
        $fs = $fromFs->reject(fn($i) => $db->has($i['key']))->keyBy('key');

        $this->items = collect($db->concat($fs))
            ->sortByDesc('modified')
            ->values(); // Mantenemos colección
        Log::info("Total de PDFs cargados: " . $this->items->count());
    }

    protected function lastModifiedSafe(string $path): int
    {
        try {
            return Storage::disk('public')->lastModified($path) ?? 0;
        } catch (\Throwable $e) {
            Log::error("Error lastModified {$path}: {$e->getMessage()}");
            return 0;
        }
    }

    // Se ejecuta automáticamente al cambiar search
    public function updatedSearch()
    {
        $this->page = 1;
        Log::info("Busqueda actualizada: {$this->search}");
    }

    public function updatedPerPage()
    {
        $this->page = 1;
        Log::info("PerPage actualizado a: {$this->perPage}");
    }

    protected function filtered()
    {
        $q = Str::lower(trim($this->search));
        $filtered = $q === ''
            ? $this->items
            : $this->items->filter(function ($it) use ($q) {
                return Str::contains(Str::lower($it['filename']), $q)
                    || Str::contains(Str::lower($it['display']), $q)
                    || Str::contains(Str::lower($it['source']), $q);
            });
        Log::info("Filtered count: " . $filtered->count() . " para búsqueda: {$q}");
        return $filtered->values();
    }

    public function getItemsPageProperty()
    {
        $data  = $this->filtered();
        $start = ($this->page - 1) * $this->perPage;
        $slice = $data->slice($start, $this->perPage)->values();
        Log::info("ItemsPage: mostrando desde {$start} cantidad {$slice->count()}");
        return $slice;
    }

    public function getTotalProperty()
    {
        return $this->filtered()->count();
    }

    public function nextPage()
    {
        if ($this->page * $this->perPage < $this->total) {
            $this->page++;
            Log::info("Página siguiente: {$this->page}");
        }
    }

    public function prevPage()
    {
        if ($this->page > 1) {
            $this->page--;
            Log::info("Página anterior: {$this->page}");
        }
    }

    public function download($path)
    {
        $basename = basename($path);
        $realPath = $this->dir() . '/' . $basename;

        if (!file_exists(Storage::disk('public')->path($realPath))) {
            session()->flash('error', 'Archivo no encontrado.');
            Log::warning("Intento descargar PDF no existente: {$realPath}");
            return;
        }

        Log::info("Descargando PDF: {$realPath}");
        return response()->download(Storage::disk('public')->path($realPath), $basename);
    }

    public function deleteByPath($path)
    {
        $basename = basename($path);
        $realPath = $this->dir() . '/' . $basename;

        if (!Storage::disk('public')->exists($realPath)) {
            session()->flash('error', 'Archivo no encontrado o ya eliminado.');
            Log::warning("Intento eliminar PDF no existente: {$realPath}");
            return;
        }

        Storage::disk('public')->delete($realPath);
        Log::info("Archivo eliminado: {$realPath}");

        PdfHistorial::where('paciente_id', $this->pacienteId)
            ->where(function ($q) use ($realPath, $basename) {
                $q->where('file', $realPath)->orWhere('file', 'like', "%{$basename}");
            })->delete();

        PdfPsiquiatra::where('paciente_id', $this->pacienteId)
            ->where(function ($q) use ($realPath, $basename) {
                $q->where('filepath', $realPath)->orWhere('filepath', 'like', "%{$basename}");
            })->delete();

        $this->loadPdfs();
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
