<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Paciente;
use App\Models\PdfPsiquiatra;

class PdfPsiquiatraController extends Component
{
    use WithFileUploads;

    public $paciente;
    public $pdf;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    public function uploadPdf()
    {
        $this->validate([
            'pdf' => 'required|file|mimes:pdf|max:5120',
        ]);

        $path = $this->pdf->store('pdfs', 'public');

        PdfPsiquiatra::create([
            'paciente_id' => $this->paciente->id,
            'filename' => $this->pdf->getClientOriginalName(),
            'filepath' => $path,
        ]);

        $this->pdf = null;
        session()->flash('message', 'PDF cargado correctamente.');
    }

    public function render()
    {
        $pdfs = $this->paciente->pdfPsiquiatras()->latest()->get();

        return view('livewire.doctor.pdf-psiquiatra', compact('pdfs'))->layout('layouts.app');
    }
}
