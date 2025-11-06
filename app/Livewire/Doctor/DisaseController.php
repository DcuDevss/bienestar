<?php

namespace App\Livewire\Doctor;

use App\Models\Disase;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class DisaseController extends Component
{
    use WithPagination;
    public $buscar='';
    public $perPage1 = '4';
    public $sort='id';
    public $direction='desc';
    public $arma=null;
    public $page;

    public $search='';
    public $perPage = '4';
    public $sort1='id';
    public $direction1='desc';
    protected $queryString = [
        'perPage'=>['except'=>'4'],
        'perPage1'=>['except'=>'4'],
        'direction'=>['except'=>'desc'],
        'direction1'=>['except'=>'desc'],
        'search'=>['except'=>''],
        'buscar'=>['except'=>''],
        'sort'=>['except'=>'id'],
        'sort1'=>['except'=>'id'],
    ];
    protected $listeners = ['render'=> 'render'];


    public $disaseId;
    public $name, $symptoms;

    public $modal = false;
    public $modalEdit = false;

    protected $rules = ['name' => 'required'];

    public function addDisase()
    {
        $this->validate();

        Disase::create([
            'name'     => mb_strtolower($this->name),
            'slug'     => Str::slug($this->name),
            'symptoms' => mb_strtolower($this->symptoms),
        ]);

        // Limpio y cierro
        $this->reset(['name', 'symptoms', 'modal']);

        // Opcional: toast
        $this->dispatch('swal',
            title : 'Enfermedad creada',
            text  : 'La enfermedad fue registrada correctamente.',
            icon  : 'success',
        );
    }




    public function edit(Disase $disase)
    {
        $this->disaseId = $disase->id;
        $this->name = $disase->name;
        $this->symptoms = $disase->symptoms;
        $this->modalEdit = true;
    }

    public function update(Disase $disase)
    {
    $this->validate();

    $disase = Disase::findOrFail($this->disaseId);
    $disase->name     = mb_strtolower($this->name);
    $disase->slug     = Str::slug($this->name);
    $disase->symptoms = mb_strtolower($this->symptoms);
    $disase->save();

    $this->reset(['name', 'symptoms', 'disaseId', 'modalEdit']);

    // opcional: notificación
    $this->dispatch('swal',
        title : 'Actualizado',
        text  : 'La enfermedad fue modificada correctamente.',
        icon : 'success',
    );
    }

    public function confirmarEliminar($id)
    {
        $this->dispatch('confirm', [
            'title'       => '¿Eliminar enfermedad?',
            'text'        => 'Esta acción no se puede deshacer.',
            'icon'        => 'warning',
            'confirmText' => 'Sí, eliminar',
            'cancelText'  => 'Cancelar',
            'action'      => 'eliminarConfirmado',
            'id'          => $id,
        ]);
    }

    public function eliminarConfirmado($id)
    {
        if ($disase = Disase::find($id)) {
            $disase->delete();

            $this->dispatch('swal',
                title: 'Eliminada',
                text: 'La enfermedad fue eliminada correctamente.',
                icon: 'success',
            );
        }
    }

    public function order1($sort1)
    {
        if($this->sort1==$sort1){
            if ($this->direction1=='desc') {
                $this->direction1 ='asc';
            } else {
                $this->direction1='desc';
            }
        } else{
            $this->sort1=$sort1;
            $this->direction1 ='asc';
        }
    }

    public function clear()
    {
        $this->page = 1;
       // $this->orde = nuull;
       // $this->camp = null;
       // $this->icon = '-circle';
        $this->search = '';
        $this->perPage = 4;
        $this->perPage1 = 4;

        $this->buscar='';
        $this->sort='id';
        $this->direction='desc';
        $this->sort1='id';
        $this->direction1='desc';
        //$this->order='desc';
        //$this->order1='desc';
    }

    public function updatingSearch(){

        $this->resetPage();

    }

    public function render()
    {
        $disases = Disase::where(function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('symptoms', 'like', "%{$this->search}%");
        })
        ->orderBy($this->sort1, $this->direction1)
        ->paginate($this->perPage);

        return view('livewire.doctor.disase-controller', ['disases' => $disases])->layout('layouts.app');
    }
}

/*
namespace App\Http\Livewire\Doctor;

use App\Models\Disase;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class DisaseController extends Component
{

    use WithPagination;
    public $search='';
    public $perPage=3;
    public $sortAsc=true;
    public $sortField = 'name';
    public $disaseId;

    public $name, $symptoms;

    public $modal = false;
    public $modalEdit = false;

    protected $rules = ['name' => 'required'];

    public function addDisase()
    {
        $this->validate();
        $disase = Disase::create([
            'name' => mb_strtolower($this->name),
            'slug' => Str::slug($this->name),
            'symptoms' => mb_strtolower($this->symptoms),
        ]);
        $this->reset(['name', 'symptoms']);
        $this->render();
        $this->modal = false;
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function edit(Disase $disase){
        $this->disaseId = $disase->id;
              $this->name = $disase->name;
              $this->symptoms = $disase->symptoms;
              $this->modalEdit = true;
    }

    public function update(Disase $disase){
        $this->validate();
        $disase->name=mb_strtolower($this->name);
        $disase->slug = Str::slug($this->name);
        $disase->symptoms=mb_strtolower($this->symptoms);
        $disase->save();
        $this->reset(['name', 'symptoms']);
        $this->modalEdit = false;
        $this->render();
    }

    public function delete(Disase $disase){
        $disase->delete();
    }


    public function render()
    {
        $disases = Disase::search($this->search)->orderBy($this->sortField, $this->sortAsc ? 'asc' : 'desc')->paginate($this->perPage);

        return view('livewire.doctor.disase-controller', ['disases' => $disases])->layout('layouts.doctor');
    }
}
*/
