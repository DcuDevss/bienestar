<?php

namespace App\Http\Controllers\Kinesiologia;

use App\Http\Controllers\Controller;
use App\Models\FichaKinesiologica;

class FichaPdfController extends Controller
{
    public function view($fichaId)
    {
        $ficha = FichaKinesiologica::with(['paciente', 'doctor', 'obraSocial', 'user'])->findOrFail($fichaId);

        return view('livewire.kinesiologia.pdf-ficha', compact('ficha'));
    }
}
