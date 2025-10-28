<?php

namespace App\Livewire\Doctor;

use App\Models\Oficina;
use Livewire\Component;
/* comentario */
class OficinaController extends Component
{
    public $local,$address,$email,$phone,$mobil,$lat,$lgn,$map,$doctor_id,$oficina_id;
    public $officeAddModal = false;
    public $officeEditModal = false;
    public $officeDeleteModal=false;


    protected $rules=['local'=>'required', 'address'=>'required','phone'=>'nullable'];

    public function openAddModal(){
        $this->officeAddModal=true;
    }

    public function openEditModal(Oficina $oficina){
        $this->local=$oficina->local;
        $this->address=$oficina->address;
        $this->email=$oficina->email;
        $this->phone=$oficina->phone;
        $this->mobil=$oficina->mobil;
        $this->lat=$oficina->lat;
        $this->lgn=$oficina->lgn;
        $this->map=$oficina->map;
        $this->oficina_id=$oficina->id;
        $this->officeEditModal=true;
    }

    public function editOffice(Oficina $oficina){
        $oficina->local = $this->local;
        $oficina->address = $this->address;
        $oficina->phone = $this->phone;
        $oficina->mobil = $this->mobil;
        $oficina->email = $this->email;
        $oficina->lat = $this->lat;
        $oficina->lgn = $this->lgn;
        $oficina->map = $this->map;
        $oficina->save();
        $this->officeEditModal=false;
    }

    public function openDeleteModal(Oficina $oficina){
        $this->local = $oficina->local;
        $this->address = $oficina->address;
        $this->oficina_id=$oficina->id;
        $this->officeDeleteModal=true;
    }

    public function delOffice(){
        $oficina = Oficina::find($this->oficina_id);
        $oficina->delete();
        $this->officeDeleteModal=false;
    }



    public function addOffice(){
        $data = $this->validate();
        $this->doctor_id = auth()->user()->id;
        $oficina = Oficina::create([
            'local'=>$data['local'],
            'address'=>$data['address'],
            'phone'=>$data['phone'],
            'mobil'=>$this->mobil,
            'email'=>$this->email,
            'lat'=>$this->lat,
            'lgn'=>$this->lgn,
            'map'=>$this->map,
            'doctor_id'=>$this->doctor_id,
        ]);

        $this->officeAddModal=false;
        $this->reset();
        session()->flash('success','registro creado exitosamente');
    }



    public function render()
    {
        $oficinas = Oficina::where('doctor_id',auth()->user()->id)->get();
        return view('livewire.doctor.oficina-controller',[
            'oficinas'=>$oficinas
        ])->layout('layouts.app');
    }
}
