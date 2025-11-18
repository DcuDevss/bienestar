<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfKinesiologia;
use App\Models\Paciente;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth; // Asegúrate de importar Auth si usas el usuario logeado en audit_log

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

        $uploadedCount = 0; // Contador para la auditoría

        foreach ($this->pdfs as $pdf) {
            // 1. Obtener datos originales
            $originalFilename = $pdf->getClientOriginalName();
            $baseName = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();

            // 2. 💡 CORRECCIÓN: Convertir el nombre base a un "slug" seguro
            $safeName = \Illuminate\Support\Str::slug($baseName); // Ej: "informe-final-paciente"

            // 3. Generar sello de tiempo (formato 'd-m-Y_H-i-s')
            $fecha = Carbon::now()->setTimezone('America/Argentina/Buenos_Aires')->format('d-m-Y_H-i-s');

            // 4. Construir el nombre final único y seguro
            $uniqueName = "{$safeName}_{$fecha}.{$extension}";

            // La ruta de almacenamiento sigue la estructura: storage/app/public/pdfhistoriales/{paciente_id}/...
            $path = $pdf->storeAs(
                "public/pdfhistoriales/{$this->paciente->id}",
                $uniqueName // Usamos el nombre seguro
            );

            // 🧩 Crear registro en BD
            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename' => $originalFilename, // 💡 Guardamos el nombre original para mostrar al usuario
                'filepath' => str_replace('public/', '', $path), // Almacenamos la ruta relativa al disco 'public'
            ]);

            $uploadedCount++;
        }

        // 🧾 AUDITORÍA (Después de completar la subida)
        if ($uploadedCount > 0) {
            // Primer parámetro (Acción): 'PDF Kinesiologia'
            // Tercer parámetro (Descripción): 'Se adjunta PDF Kinesiologia'
            audit_log('PDF Kinesiologia', $this->paciente, 'Se adjunta PDF al Paciente');
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
            $filenameForLog = $pdf->filename; // Capturar el nombre antes de la eliminación

            // Se asume que el filepath en la DB está sin el prefijo 'public/'.
            // Lo añadimos para que Storage::exists funcione en el disco 'public'.
            $fullPath = 'public/' . $pdf->filepath;

            if (Storage::exists($fullPath)) {
                Storage::delete($fullPath);
            }

            $pdf->delete();

            // 🧾 AUDITORÍA (Después de la eliminación exitosa)
            // Primer parámetro (Acción): 'Se elimino PDF Paciente Kinesiologia'
            // Tercer parámetro (Descripción): 'Se elimina PDF'
            audit_log('Se elimino PDF Paciente Kinesiologia', $this->paciente, 'PDF Eliminado');

            $this->dispatch('pdfsActualizados'); // Evento para actualizar la vista

            $this->dispatch('swal', [
                'title' => 'PDF eliminado correctamente',
                'icon' => 'success',
            ]);
        }
    }
    
    // ... resto del componente ...

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
