<?php



namespace App\Http\Controllers\Kinesiologia;

use App\Http\Controllers\Controller;
use App\Models\FichaKinesiologica;
use Barryvdh\DomPDF\Facade\Pdf;


class FichaPdfController extends Controller
{
    public function view($fichaId)
    {
        $ficha = FichaKinesiologica::with(['paciente', 'doctor', 'obraSocial'])->findOrFail($fichaId);

        $pdf = Pdf::loadView('livewire.kinesiologia.pdf-ficha', compact('ficha'))
            ->setPaper('a4', 'portrait');

        return $pdf->stream("ficha_{$fichaId}.pdf");
    }
}
