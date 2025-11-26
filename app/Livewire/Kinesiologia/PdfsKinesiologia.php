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
            // Incluyo 'max:10240' de nuevo, ya que es una buena práctica (10MB)
            'pdfs.*' => 'required|mimes:pdf|max:10240',
        ]);

        $uploadedCount = 0; // Contador para la auditoría

        foreach ($this->pdfs as $pdf) {
            // 1. Obtener datos originales
            $originalFilename = $pdf->getClientOriginalName();
            $baseName = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();

            // 2. ✅ CORRECCIÓN: Limpieza simple para nombre de archivo (evita Str::slug)
            // Esto reemplaza espacios y caracteres no seguros por guiones bajos ('_')
            $safeBaseName = str_replace([' ', '/', '\\', '..', '(', ')', '[', ']'], '_', $baseName);
            // Elimina guiones bajos repetidos, útil si el nombre original ya tenía muchos espacios
            $safeBaseName = preg_replace('/_+/', '_', $safeBaseName);

            // 3. Generar sello de tiempo (formato 'd-m-Y_H-i-s')
            $fecha = Carbon::now()->setTimezone('America/Argentina/Buenos_Aires')->format('d-m-Y_H-i-s');

            // 4. Construir el nombre final único y seguro
            // Ahora el nombre en disco usará guiones bajos, coincidiendo con lo que parece esperar tu sistema.
            $uniqueName = "{$safeBaseName}_{$fecha}.{$extension}";

            // La ruta de almacenamiento sigue la estructura: storage/app/public/pdfhistoriales/{paciente_id}/...
            /*$path = $pdf->storeAs(
                "public/pdfhistoriales/{$this->paciente->id}",
                $uniqueName // Usamos el nombre seguro con guiones bajos
            );*/
            $path = $pdf->storeAs(
              "pdfhistoriales/{$this->paciente->id}",  // sin "public/"
              $uniqueName,
            'public'                                 // disco explícito
         );


            // 🧩 Crear registro en BD
            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename' => $originalFilename, // Nombre para mostrar al usuario (OK)
                // filepath ahora contiene la ruta y el nombre del archivo con guiones bajos
               // 'filepath' => str_replace('public/', '', $path),
               'filepath' => "pdfhistoriales/{$this->paciente->id}/{$uniqueName}",

            ]);

            $uploadedCount++;
        }

        // 🧾 AUDITORÍA (Después de completar la subida)
        if ($uploadedCount > 0) {
            audit_log('pdf.Kinesiologia', $this->paciente, 'Se adjunta PDF al Paciente');
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
     * @param int $id ID del PdfKinesiologia a eliminar
     */
    public function eliminarPdf($id)
    {
        $pdf = PdfKinesiologia::find($id);

        if ($pdf) {
            $filenameForLog = $pdf->filename; // Capturar el nombre antes de la eliminación

            // 1. Ruta relativa almacenada en la DB
            $relative_path = $pdf->filepath;

            // 2. Eliminar del disco 'public' (usando el disco explícitamente, mejor práctica)
            if (Storage::disk('public')->exists($relative_path)) {
                Storage::disk('public')->delete($relative_path);
            }

            // 3. Eliminar de la base de datos
            $pdf->delete();

            // 🧾 AUDITORÍA (Después de la eliminación exitosa)
            audit_log('eliminar.pdf', $this->paciente, 'PDF Eliminado');

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
