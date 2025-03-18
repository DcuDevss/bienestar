<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Livewire\Attributes\On;

class CurriculumController extends Controller
{

    #[On('reload')]
    public function index(){
        return view('doctor.curriculum');
  }
}
