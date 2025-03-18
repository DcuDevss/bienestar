<?php

// app/Http/Livewire/Paciente/VerHistorial.php
namespace App\Livewire\Paciente;

use App\Models\Paciente;
use App\Models\Pdfhistorial;
use Livewire\Component;

class VerHistorial extends Component
{
    public $pacienteId;
    public $pdfs;

    // Dentro de la clase VerHistorial
    public $search = '';
    public $perPage = 10;
    public $page = 1;


    public function mount(Paciente $paciente)
    {
        $this->pacienteId = $paciente->id;
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfs = Pdfhistorial::where('paciente_id', $this->pacienteId)->get();
    }


    public function downloadPdf($pdfId)
    {
        $selectedPdf = Pdfhistorial::findOrFail($pdfId);
        $filePath = storage_path('app/public/pdfhistoriales/' . $selectedPdf->file);

        return response()->download($filePath, $selectedPdf->file);
    }

    public function render()
    {
        return view('livewire.paciente.ver-historial')->layout('layouts.app');
    }
}
