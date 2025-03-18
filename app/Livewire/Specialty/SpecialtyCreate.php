<?php

namespace App\Livewire\Specialty;

use App\Models\Especialidade;
use Livewire\Component;

class SpecialtyCreate extends Component
{
    public $openModal = false;
    public $specialties;
    public $user_specialties_id;
    public $search;
    public $user_specialties;

    public function modify($s)
    {

        $old_ids =  $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();

        array_push($old_ids, $s);

        auth()->user()->specialties()->sync($old_ids);
        $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();

        $this->dispatch( 'reload');

    }

    public function del($s)
    {
        $old_ids = auth()->user()->specialties()
            ->pluck('especialidade_id');

        $new = $old_ids->filter(function ($i) use ($s) {
            return $i !== $s;
        });

        auth()->user()->specialties()->sync($new);

        $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();

        $this->dispatch( 'reload');


    }


    public function updatingSearch()
    {
        //$this->resetPage();
    }


    public function render()
    {
        $search = '%' . $this->search . '%';

        $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();

        $this->user_specialties = auth()->user()->specialties;


        $this->specialties = Especialidade::whereNotIn('id', $this->user_specialties_id)->where('name', 'like', $search)
            ->take(26)->get();

        return view('livewire.specialty.specialty-create');
    }
}


/*namespace App\Livewire\Specialty;

use App\Models\Especialidade;
use Livewire\Component;

class SpecialtyCreate extends Component
{
    public $openModal = false;
    public $specialties;
    public $user_specialties_id;
    public $search;
    public $user_specialties;

    public function modify($s)
    {
        $old_ids = $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();

        array_push($old_ids, $s);

        auth()->user()->specialties()->sync($old_ids);
        $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();
        $this->emitToSpecialtyList(); // Llamando al nuevo método para emitir el evento
    }

    public function del($s)
    {
        $old_ids = auth()->user()->specialties()
            ->pluck('especialidade_id');

        $new = $old_ids->filter(function ($i) use ($s) {
            return $i !== $s;
        });

        auth()->user()->specialties()->sync($new);

        $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();
        $this->emitToSpecialtyList(); // Llamando al nuevo método para emitir el evento
    }

    // Nuevo método para emitir el evento al componente SpecialtyList
    public function emitToSpecialtyList()
    {
        $this->emitTo('specialty.specialty-list', 'reload');
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $search = '%' . $this->search . '%';

        $this->user_specialties_id = auth()->user()->specialties()
            ->pluck('especialidade_id')->toArray();

        $this->user_specialties = auth()->user()->specialties;

        $this->specialties = Especialidade::whereNotIn('id', $this->user_specialties_id)
            ->where('name', 'like', $search)
            ->take(5)->get();

        return view('livewire.specialty.specialty-create');
    }
}*/
