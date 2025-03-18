<?php

/*
namespace App\Livewire\Paciente;

use App\Models\Pdfhistorial;
use Livewire\Component;
use Livewire\WithFileUploads;

class PdfViewer extends Component
{
    use WithFileUploads;

    public $patientId;
    public $pdfhistorial;
    public $pdfs;

    public function mount($paciente)
    {
        $this->pdfhistorial = $paciente;
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfs = Pdfhistorial::where('paciente_id', $this->pdfhistorial)->get();
    }

    public function render()
    {
        return view('livewire.paciente.pdf-viewer')->layout('layouts.doctor');
    }
}*/
/*
namespace App\Livewire\Paciente;

use App\Models\Pdfhistorial;
use Livewire\Component;
use Livewire\WithFileUploads;

class PdfViewer extends Component
{
    use WithFileUploads;

    public $pacienteId; // Cambiado de $patientId a $pacienteId
    public $pdfs;

    public function mount($paciente)
    {
        $this->pacienteId = $paciente; // Cambiado de $pdfhistorial a $pacienteId
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfs = Pdfhistorial::where('paciente_id', $this->pacienteId)->get();
    }

    public function render()
    {
        return view('livewire.paciente.pdf-viewer')->layout('layouts.doctor');
    }
}
*/
// app/Livewire/Paciente/PdfViewer.php
/*namespace App\Livewire\Paciente;

use App\Models\Pdfhistorial;
use Barryvdh\DomPDF\Facade as FacadePdf;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

class PdfViewer extends Component
{
    public $pacienteId;

    public function mount($paciente)
    {
        $this->pacienteId = $paciente;
    }

    public function viewPdf($pdfId)
    {
        $selectedPdf = Pdfhistorial::findOrFail($pdfId);

        // Generar el PDF usando el paquete barryvdh/laravel-dompdf
        $pdf = Pdf::loadView('livewire.paciente.pdf-viewer', ['pdfContent' => $selectedPdf->content]);

        // Descargar el PDF
        return $pdf->stream('pdf-viewer.pdf');
    }

    public function render()
    {
        $pdfs = Pdfhistorial::where('paciente_id', $this->pacienteId)->get();
        return view('livewire.paciente.pdf-viewer', ['pdfs' => $pdfs])->layout('layouts.doctor');
    }
}
*/




namespace App\Http\Livewire\Paciente;

use App\Models\Pdfhistorial;
use Livewire\Component;
use Livewire\WithFileUploads;

class PdfViewer extends Component
{
    use WithFileUploads;

    public $patientId;
    public $pdfs;

    public function mount($patientId)
    {
        $this->patientId = $patientId;
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfs = Pdfhistorial::where('paciente_id', $this->patientId)->get();
    }

    public function render()
    {
        return view('livewire.paciente.pdf-viewer');
    }
}


