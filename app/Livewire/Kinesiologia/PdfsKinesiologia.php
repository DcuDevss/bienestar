<?php

namespace App\Livewire\Kinesiologia;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\PdfKinesiologia;
use App\Models\Paciente;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Helpers\PdfCrypto;
use Illuminate\Support\Str;

class PdfsKinesiologia extends Component
{
    use WithFileUploads;

    public Paciente $paciente;
    public $pdfs = [];

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
    }

    public function uploadPdfs()
    {
        $this->validate([
            'pdfs.*' => 'required|mimes:pdf|max:10240',
        ]);

        $uploadedCount = 0;

        foreach ($this->pdfs as $pdf) {

            $originalFilename = $pdf->getClientOriginalName();
            $baseName = pathinfo($originalFilename, PATHINFO_FILENAME);
            $extension = $pdf->getClientOriginalExtension();

            $safeBaseName = str_replace([' ', '/', '\\', '..', '(', ')', '[', ']'], '_', $baseName);
            $safeBaseName = preg_replace('/_+/', '_', $safeBaseName);

            $fecha = Carbon::now()->setTimezone('America/Argentina/Buenos_Aires')
                ->format('d-m-Y_H-i-s');

            $uniqueName = "{$safeBaseName}_{$fecha}.{$extension}";

            $fileContents = $pdf->get();

            $relativePath = "pdfhistoriales/{$this->paciente->id}/{$uniqueName}";

            $path = PdfCrypto::storeEncrypted(
                'public',
                $relativePath,
                $fileContents
            );

            if ($path === false) {
                \Log::error("Fallo al guardar y cifrar PDF: " . $uniqueName);
                continue;
            }

            PdfKinesiologia::create([
                'paciente_id' => $this->paciente->id,
                'filename'    => $originalFilename,
                'filepath'    => $relativePath,
            ]);

            $uploadedCount++;
        }

        if ($uploadedCount > 0) {
            audit_log('pdf.Kinesiologia', $this->paciente, 'Se adjunta PDF al Paciente');
        }

        $this->reset('pdfs');
        $this->dispatch('pdfsActualizados');

        $this->dispatch('swal', [
            'title' => 'PDFs subidos correctamente (Cifrados)',
            'icon'  => 'success',
        ]);
    }

    public function downloadPdf($id)
    {
        $pdfRecord = PdfKinesiologia::find($id);

        if (!$pdfRecord) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'Registro de PDF no encontrado.',
                'icon' => 'error'
            ]);
            return;
        }

        $relative_path = $pdfRecord->filepath;
        $disk = 'public';

        $decryptedContents = PdfCrypto::getDecrypted($disk, $relative_path);

        if ($decryptedContents === null) {
            $this->dispatch('swal', [
                'title' => 'Error',
                'text' => 'No se pudo descifrar el archivo.',
                'icon' => 'error'
            ]);
            return;
        }

        return response()->streamDownload(function () use ($decryptedContents) {
            echo $decryptedContents;
        }, $pdfRecord->filename, [
            'Content-Type'   => 'application/pdf',
            'Content-Length' => strlen($decryptedContents),
        ]);
    }

    /**
     * ✅ PREVIEW SEGURO (SIN ELIMINAR NADA DE TU CÓDIGO)
     */
    public function previewPdf($id)
    {
        $pdf = PdfKinesiologia::findOrFail($id);

        $decrypted = PdfCrypto::getDecrypted('public', $pdf->filepath);

        if (!$decrypted) {
            abort(404);
        }

        return response($decrypted, 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'inline; filename="' . $pdf->filename . '"');
    }

    public function eliminarPdf($id)
    {
        $pdf = PdfKinesiologia::find($id);

        if ($pdf) {
            $relative_path = $pdf->filepath;

            if (Storage::disk('public')->exists($relative_path)) {
                Storage::disk('public')->delete($relative_path);
            }

            $pdf->delete();

            audit_log('eliminar.pdf', $this->paciente, 'PDF Eliminado');

            $this->dispatch('pdfsActualizados');

            $this->dispatch('swal', [
                'title' => 'PDF eliminado correctamente',
                'icon'  => 'success',
            ]);
        }
    }

    public function getPdfsListProperty()
    {
        return PdfKinesiologia::where('paciente_id', $this->paciente->id)
            ->latest()
            ->get();
    }

    public function render()
    {
        return view('livewire.kinesiologia.pdfs-kinesiologia', [
            'pdfsList' => $this->pdfsList,
        ])->layout('layouts.app');
    }
}
