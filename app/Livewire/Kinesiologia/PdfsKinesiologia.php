<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfKinesiologia;
use App\Models\Paciente;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PdfsKinesiologia extends Component
{
    use WithFileUploads;

    public Paciente $paciente;
    // Propiedad usada para bindear los archivos en el formulario de subida
    public $pdfs = [];

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    /**
     * Maneja la subida de uno o varios archivos PDF.
     */
    public function uploadPdfs()
    {
        // Validación de los archivos subidos
        $this->validate([
            'pdfs.*' => 'required|mimes:pdf|max:10240', // Máx 10MB por archivo
        ]);

        foreach ($this->pdfs as $pdf) {
            // 🕒 Fecha actual para el nombre del archivo
            $fecha = Carbon::now()->setTimezone('America/Argentina/Buenos_Aires')->format('d-m-Y_H-i-s');

            // 📄 Obtener nombre original sin extensión
            $originalName = pathinfo($pdf->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();

            // 🔠 Generar nombre único y descriptivo
            $uniqueName = "{$originalName}_{$fecha}.{$extension}";

            // La ruta de almacenamiento sigue la estructura: storage/app/public/pdfhistoriales/{paciente_id}/...
            $path = $pdf->storeAs(
                "public/pdfhistoriales/{$this->paciente->id}",
                $uniqueName
            );

            // 🧩 Crear registro en BD
            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename' => $uniqueName,
                // Almacenamos la ruta relativa al disco 'public'
                'filepath' => str_replace('public/', '', $path),
            ]);
        }

        // 🔄 Limpiar input y recargar la lista de PDFs
        $this->reset('pdfs');
        $this->dispatch('pdfsActualizados'); // Evento para actualizar la vista

        // ✅ Notificación
        $this->dispatch('swal', [
            'title' => 'PDFs subidos correctamente',
            'icon' => 'success',
        ]);
    }

    /**
     * Elimina un PDF del storage y de la base de datos.
     * * @param int $id ID del PdfKinesiologia a eliminar
     */
    public function eliminarPdf($id)
    {
        $pdf = PdfKinesiologia::find($id);

        if ($pdf) {
            // Se asume que el filepath en la DB está sin el prefijo 'public/'.
            // Lo añadimos para que Storage::exists funcione en el disco 'public'.
            $fullPath = 'public/' . $pdf->filepath;

            if (Storage::exists($fullPath)) {
                Storage::delete($fullPath);
            }

            $pdf->delete();

            $this->dispatch('pdfsActualizados'); // Evento para actualizar la vista

            $this->dispatch('swal', [
                'title' => 'PDF eliminado correctamente',
                'icon' => 'success',
            ]);
        }
    }

    /**
     * Propiedad Calculada (Computed Property) para obtener la lista de PDFs.
     * Livewire la mapea a $this->pdfsList.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getPdfsListProperty()
    {
        return PdfKinesiologia::where('paciente_id', $this->paciente->id)
            ->latest()
            ->get();
    }

    /**
     * Renderiza la vista del componente.
     */
    public function render()
    {
        return view('livewire.kinesiologia.pdfs-kinesiologia', [
            // Accedemos a la propiedad calculada usando su nombre de variable
            'pdfsList' => $this->pdfsList,
        ])->layout('layouts.app');
    }
}
