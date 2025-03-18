<?php

namespace App\Livewire\Specialty;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class SpecialtyList extends Component
{

    public $specialties=[];//aqui van todas las especilidades del doctor esto se saca de la relicion que se ttiene con las especialidades

    protected $listeners=['reload'=>'reload'];

    //#[On('reload')]

    public function reload()
    {
        $this->specialties = auth()->user()->specialties;
    }

    public function render()
    {
        $this->specialties = auth()->user()->specialties;
        return view('livewire.specialty.specialty-list');
    }
}
