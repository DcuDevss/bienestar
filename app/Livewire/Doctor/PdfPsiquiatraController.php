<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Paciente;
use App\Models\PdfPsiquiatra;
use Illuminate\Support\Facades\Storage;

class PdfPsiquiatraController extends Component
{
    use WithFileUploads;

    public $paciente;
    public $pdfs = []; // Array para múltiples archivos
    public $pdfsList;  // Lista de PDFs para mostrar

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfsList = $this->paciente->pdfPsiquiatras()->latest()->get();
    }

    public function uploadPdfs()
    {
        $this->validate([
            'pdfs.*' => 'required|file|mimes:pdf|max:5120',
        ]);

        foreach ($this->pdfs as $pdf) {
            $path = $pdf->store('pdfs', 'public');

            PdfPsiquiatra::create([
                'paciente_id' => $this->paciente->id,
                'filename' => $pdf->getClientOriginalName(),
                'filepath' => $path,
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
