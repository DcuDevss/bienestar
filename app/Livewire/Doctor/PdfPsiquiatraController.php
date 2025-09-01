<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Paciente;
use App\Models\PdfPsiquiatra;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PdfPsiquiatraController extends Component
{
    use WithFileUploads;

    public $paciente;
    public $pdfs = []; // múltiples archivos
    public $pdfsList;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfsList = PdfPsiquiatra::where('paciente_id', $this->paciente->id)
            ->latest()
            ->get()
            ->filter(fn ($r) => Storage::disk('public')->exists($r->filepath))
            ->values();
    }


    /**
     * Carpeta base para este paciente.
     * Queda: public/pacientes/{id}/pdfs
     */
    protected function storageDir(): string
    {
        return "pdfhistoriales/{$this->paciente->id}";
    }

    public function uploadPdfs()
    {
        $this->validate([
            'pdfs.*' => 'required|file|mimes:pdf|max:5120',
        ]);

        foreach ($this->pdfs as $pdf) {
            $orig  = $pdf->getClientOriginalName();
            $ext   = $pdf->getClientOriginalExtension();
            $base  = pathinfo($orig, PATHINFO_FILENAME);
            $safe  = \Illuminate\Support\Str::slug($base);
            $name  = $safe.'_'.now()->format('Ymd_His').'_'.\Illuminate\Support\Str::random(6).'.'.$ext;

            // 👉 misma carpeta que el file-controller
            $path = $pdf->storeAs($this->storageDir(), $name, 'public');

            \App\Models\PdfPsiquiatra::create([
                'paciente_id' => $this->paciente->id,
                'filename'    => $orig,
                'filepath'    => $path,
            ]);
        }

        $this->pdfs = [];
        $this->loadPdfs();
        session()->flash('message', 'PDFs cargados correctamente.');
    }

    public function eliminarPdf($pdfId)
    {
        $pdf = PdfPsiquiatra::find($pdfId);

        if ($pdf) {
            if (Storage::disk('public')->exists($pdf->filepath)) {
                Storage::disk('public')->delete($pdf->filepath);
            }

            $pdf->delete();
            $this->loadPdfs();

            session()->flash('message', 'PDF eliminado correctamente.');
        } else {
            session()->flash('error', 'PDF no encontrado.');
        }
    }

    public function render()
    {
        return view('livewire.doctor.pdf-psiquiatra')->layout('layouts.app');
    }
}
