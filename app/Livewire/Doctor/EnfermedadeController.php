<?php

namespace App\Livewire\Doctor;

use App\Models\Enfermedade;
use App\Models\Tipolicencia;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Str;

class EnfermedadeController extends Component
{
    /* use WithPagination;
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


    public $enfermedadeId;
    public $name, $symptoms,$fecha_atencion,$fecha_finalizacion,$horas_salud,$archivo,$activo,$tipolicencia_id,$tipodelicencia;
    public $enfermedades;
    public $Tipolicencias=[];

    public $modal = false;
    public $modalEdit = false;

    protected $rules = [
        'name' => 'required',
        'fecha_atencion' => 'nullable',
        'fecha_finalizacion' => 'nullable',
        'horas_salud' => 'nullable',
        'archivo' => 'nullable',
        'activo' => 'nullable',
        'symptoms'=>'nullable',
        'tipodelicencia'=>'nullable',
        'tipolicencia_id'=>'nullable',
    ];





    public function addDisase()
    {
        $this->validate();

        $data = [
            'name' => mb_strtolower($this->name),
            'slug' => Str::slug($this->name),
            'symptoms' => mb_strtolower($this->symptoms),
            'fecha_atencion' => $this->fecha_atencion,
            'fecha_finalizacion' => $this->fecha_finalizacion,
            'horas_salud' => mb_strtolower($this->horas_salud),
            'archivo' => mb_strtolower($this->archivo),
            'activo' => $this->activo,
            'tipolicencia_id' => $this->tipolicencia_id,
            'tipodelicencia' => mb_strtolower($this->tipodelicencia),
        ];

        // Asegúrate de que las fechas estén en el formato correcto
        $data['fecha_atencion'] = $data['fecha_atencion'] ? now()->toDateTimeString() : null;
        $data['fecha_finalizacion'] = $data['fecha_finalizacion'] ? now()->toDateTimeString() : null;

        Enfermedade::create($data);

        $this->reset([
            'name',
            'fecha_atencion',
            'fecha_finalizacion',
            'horas_salud',
            'tipolicencia_id',
            'tipodelicencia',
            'symptoms',
            'activo',
            'archivo',
            'search',
        ]);

        $this->render();
        $this->modal = false;
    }



    public function edit(Enfermedade $enfermedade)
    {
        $this->enfermedadeId = $enfermedade->id;
        $this->name = $enfermedade->name;
        $this->symptoms = $enfermedade->symptoms;
        $this->fecha_atencion = $enfermedade->fecha_atencion;
        $this->fecha_finalizacion = $enfermedade->fecha_finalizacion;
        $this->horas_salud = $enfermedade->hotras_salud;
        $this->activo = $enfermedade->activo;
        $this->archivo = $enfermedade->archivo;
        $this->tipodelicencia = $enfermedade->tipodelicencia;
        $this->tipolicencia_id = $enfermedade->tipolicencia_id;

        $this->modalEdit = true;
    }

    public function update(Enfermedade $enfermedade)
    {
        $this->validate();

        $enfermedade->name = mb_strtolower($this->name);
        $enfermedade->slug = Str::slug($this->name);
        $enfermedade->symptoms = mb_strtolower($this->symptoms);
        $enfermedade->fecha_finalizacion = $this->fecha_finalizacion;
        $enfermedade->fecha_atencion = $this->fecha_atencion;
        $enfermedade->horas_salud = mb_strtolower($this->horas_salud);
        $enfermedade->activo = $this->activo;
        $enfermedade->archivo = mb_strtolower($this->archivo);
        $enfermedade->tipolicencia_id = $this->tipolicencia_id;
        $enfermedade->tipodelicencia = mb_strtolower($this->tipodelicencia);

        // Asegúrate de que las fechas estén en el formato correcto
        $enfermedade->fecha_atencion = $enfermedade->fecha_atencion ? now()->toDateTimeString() : null;
        $enfermedade->fecha_finalizacion = $enfermedade->fecha_finalizacion ? now()->toDateTimeString() : null;

        $enfermedade->save();

        $this->reset([
            'name',
            'fecha_atencion',
            'fecha_finalizacion',
            'horas_salud',
            'tipolicencia_id',
            'tipodelicencia',
            'symptoms',
            'activo',
            'archivo',
            'search'
        ]);

        $this->modalEdit = false;
        $this->render();
    }

    public function delete(Enfermedade $enfermedade)
    {
        $enfermedade->delete();
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
       // $this->orde = null;
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
*/

    public function render()
    {
       /* $enfermedade = Enfermedade::where(function ($query) {
            $query->where('name', 'like', "%{$this->search}%")
                ->orWhere('symptoms', 'like', "%{$this->search}%");
        }),['enfermedade' => $enfermedade])
        ->orderBy($this->sort1, $this->direction1)
        ->paginate($this->perPage);*/
        return view('livewire.doctor.enfermedade-controller')->layout('layouts.app');
    }
}
