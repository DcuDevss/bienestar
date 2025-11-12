<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfKinesiologia;
use App\Models\Paciente;
use Illuminate\Support\Facades\Storage;

class PdfsKinesiologia extends Component
{
    use WithFileUploads;

    public $paciente;
    public $pdfs = [];

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }
    //Funciona bien
    /*    public function uploadPdfs()
    {
        $this->validate([
            'pdfs.*' => 'required|mimes:pdf|max:10240', // Máx 10MB por archivo
        ]);

        foreach ($this->pdfs as $pdf) {
            $filename = $pdf->getClientOriginalName(); // ✅ Nombre original del archivo

            // ✅ Ruta donde se guardará
            $path = $pdf->storeAs(
                "public/pdfhistoriales/{$this->paciente->id}/kinesiologia",
                $filename
            );

            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename' => $filename,
                'filepath' => $path,
            ]);
        }

        // Limpiamos el input de archivos
        $this->reset('pdfs');

        // Alerta de éxito
        $this->dispatch('swal', [
            'title' => 'PDFs subidos correctamente',
            'icon' => 'success',
        ]);
    } */

    //Nuevo 
    public function uploadPdfs()
    {
        $this->validate([
            'pdfs.*' => 'required|mimes:pdf|max:10240', // Máx 10MB por archivo
        ]);

        foreach ($this->pdfs as $pdf) {
            // 🕒 Fecha actual en formato español
            $fecha = now()->setTimezone('America/Argentina/Buenos_Aires')->format('d-m-Y_H-i-s');

            // 📄 Obtener nombre original sin extensión
            $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();

            // 🔠 Generar nombre único y descriptivo
            $uniqueName = "{$originalName}_{$fecha}.{$extension}";

            // 📁 Guardar en storage
            $path = $pdf->storeAs(
                "public/pdfhistoriales/{$this->paciente->id}/kinesiologia",
                $uniqueName
            );

            // 🧩 Crear registro en BD
            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename' => $uniqueName,
                'filepath' => $path,
            ]);
        }

        // 🔄 Limpiar input
        $this->reset('pdfs');

        // ✅ Notificación
        $this->dispatch('swal', [
            'title' => 'PDFs subidos correctamente',
            'icon' => 'success',
        ]);
    }




    public function eliminarPdf($id)
    {
        $pdf = PdfKinesiologia::find($id);

        if ($pdf) {
            if (Storage::exists($pdf->filepath)) {
                Storage::delete($pdf->filepath);
            }

            $pdf->delete();

            $this->dispatch('swal', [
                'title' => 'PDF eliminado correctamente',
                'icon' => 'success',
            ]);
        }
    }

    public function getPdfsProperty()
    {
        return PdfKinesiologia::where('paciente_id', $this->paciente->id)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.kinesiologia.pdfs-kinesiologia', [
            'pdfsList' => PdfKinesiologia::where('paciente_id', $this->paciente->id)->get(),
        ])->layout('layouts.app');
    }
}
