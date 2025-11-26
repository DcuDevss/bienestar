<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfKinesiologia;
use App\Models\Paciente;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PdfsKinesiologia extends Component
{
    use WithFileUploads;

    public Paciente $paciente;
    public $pdfs = [];
    public $pdfsList;

    /**
     * Inicializa el componente.
     */
    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
        $this->loadPdfs();
    }

    /**
     * Retorna el directorio donde se guardarán los PDFs.
     */
    protected function storageDir(): string
    {
        return "pdfhistoriales/{$this->paciente->id}";
    }

    /**
     * Carga los PDFs existentes en BD + storage.
     */
    public function loadPdfs()
    {
        $this->pdfsList = PdfKinesiologia::where('paciente_id', $this->paciente->id)
            ->latest()
            ->get()
            ->filter(fn($r) => Storage::disk('public')->exists($r->filepath))
            ->values();
    }

    /**
     * Maneja la subida de uno o varios archivos PDF.
     */
    public function uploadPdfs()
    {
        $this->validate([
            'pdfs'   => 'required|array|min:1',
            'pdfs.*' => 'file|mimes:pdf|max:10240',
        ]);

        foreach ($this->pdfs as $pdf) {

            // Datos originales
            $orig  = $pdf->getClientOriginalName();
            $ext   = $pdf->getClientOriginalExtension();
            $base  = pathinfo($orig, PATHINFO_FILENAME);

            // Igual que Psiquiatría → solo SLUG
            $safe  = \Illuminate\Support\Str::slug($base);

            // Timestamp argentino
            $fecha = now()
                ->setTimezone('America/Argentina/Buenos_Aires')
                ->format('d-m-Y_His');

            // Nombre final UNIFICADO
            $name = "{$safe}_{$fecha}_" . \Illuminate\Support\Str::random(6) . ".{$ext}";

            // Guardar igual que antes
            $path = $pdf->storeAs(
                $this->storageDir(),
                $name,
                'public'
            );

            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename'    => $orig,
                'filepath'    => $path,
            ]);
        }

        audit_log(
            'pdf.kinesiologia.create',
            $this->paciente,
            "PDFs cargados"
        );

        $this->reset('pdfs');
        $this->loadPdfs();

        $this->dispatch('swal', [
            'title' => 'PDFs subidos correctamente',
            'icon'  => 'success',
        ]);
    }


    /**
     * Confirmación desde el botón Eliminar.
     */
    public function confirmarEliminar($pdfId)
    {
        $this->dispatch('confirm', [
            'title'       => '¿Eliminar PDF?',
            'text'        => 'Esta acción no se puede deshacer.',
            'icon'        => 'warning',
            'confirmText' => 'Sí, eliminar',
            'cancelText'  => 'Cancelar',
            'id'          => $pdfId,
        ]);
    }

    /**
     * Elimina un PDF del storage y de la base de datos.
     */
    public function eliminarPdf($id)
    {
        $pdf = PdfKinesiologia::find($id);

        if (!$pdf) {
            $this->dispatch('swal', [
                'title' => 'No encontrado',
                'text'  => 'El PDF no existe.',
                'icon'  => 'error',
            ]);
            return;
        }

        $filenameForLog = $pdf->filename;

        // Eliminar archivo físico
        if (Storage::disk('public')->exists($pdf->filepath)) {
            Storage::disk('public')->delete($pdf->filepath);

            audit_log(
                'pdf.kinesiologia.deleted.file',
                $this->paciente,
                "Archivo PDF eliminado: {$filenameForLog}"
            );
        }

        // Eliminar BD
        $pdf->delete();

        audit_log(
            'pdf.kinesiologia.deleted.db',
            $this->paciente,
            "Registro PDF eliminado: {$filenameForLog}"
        );

        $this->loadPdfs();

        $this->dispatch('swal', [
            'title' => 'PDF eliminado correctamente',
            'icon'  => 'success',
        ]);
    }

    /**
     * Renderiza la vista del componente.
     */
    public function render()
    {
        return view('livewire.kinesiologia.pdfs-kinesiologia', [
            'pdfsList' => $this->pdfsList,
        ])->layout('layouts.app');
    }
}
