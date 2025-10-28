<?php

namespace App\Livewire\Doctor;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Paciente;
use App\Models\PdfPsiquiatra;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Attributes\On;

class PdfPsiquiatraController extends Component
{
    use WithFileUploads;

    public $paciente;
    public $pdfs = [];
    public $pdfsList;

    public function mount(Paciente $paciente)
    {
        $this->paciente = $paciente;
        $this->loadPdfs();
    }

    public function loadPdfs()
    {
        $this->pdfsList = PdfPsiquiatra::where('paciente_id', $this->paciente->id)
            ->latest()
            ->get()
            ->filter(fn ($r) => Storage::disk('public')->exists($r->filepath))
            ->values();
    }

    protected function storageDir(): string
    {
        return "pdfhistoriales/{$this->paciente->id}";
    }

   public function uploadPdfs()
    {
        // 1) Guard clause: nada seleccionado
        if (empty($this->pdfs) || count($this->pdfs) === 0) {
            $this->dispatch('swal', title: 'Sin archivos', text: 'Seleccioná al menos un PDF para subir.', icon: 'error');
            return;
        }

        // 2) Validación completa
        $this->validate([
            'pdfs'   => 'required|array|min:1',
            'pdfs.*' => 'file|mimes:pdf|max:5120',
        ]);

        foreach ($this->pdfs as $pdf) {
            $orig  = $pdf->getClientOriginalName();
            $ext   = $pdf->getClientOriginalExtension();
            $base  = pathinfo($orig, PATHINFO_FILENAME);
            $safe  = \Illuminate\Support\Str::slug($base);
            $name  = $safe.'_'.now()->format('Ymd_His').'_'.\Illuminate\Support\Str::random(6).'.'.$ext;

            $path = $pdf->storeAs($this->storageDir(), $name, 'public');

            \App\Models\PdfPsiquiatra::create([
                'paciente_id' => $this->paciente->id,
                'filename'    => $orig,
                'filepath'    => $path,
            ]);
        }

        $this->reset('pdfs'); // o $this->pdfs = [];
        $this->loadPdfs();

        $this->dispatch('swal', title: 'Cargado', text: 'PDF(s) cargados correctamente.', icon: 'success');
    }


    public function confirmarEliminar($pdfId)
    {
        $this->dispatch('confirm', [
            'title'       => '¿Eliminar PDF?',
            'text'        => 'Esta acción no se puede deshacer.',
            'icon'        => 'warning',
            'confirmText' => 'Sí, eliminar',
            'cancelText'  => 'Cancelar',
            'id'          => $pdfId,   // 👈 pasamoos solo el id
        ]);
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

            // ✅ éxito
            $this->dispatch('swal', title: 'Eliminado', text: 'PDF eliminado correctamente.', icon: 'success');
        } else {
            // ⚠️ no encontrado
            $this->dispatch('swal', title: 'No encontrado', text: 'El PDF no existe.', icon: 'error');
        }
    }


    public function render()
    {
        return view('livewire.doctor.pdf-psiquiatra')->layout('layouts.app');
    }
}
