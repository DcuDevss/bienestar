<?php

namespace App\Http\Controllers\Psicologo;

use App\Http\Controllers\Controller;
use App\Models\Paciente;
use Illuminate\Http\Request;
use WithPagination;

class PsicologoController extends Controller
{
    public function index(){
        $pacientes=Paciente::paginate('10');
        return view('psicologo.psicologo',compact('pacientes'));
  }
}
