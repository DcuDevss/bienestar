<?php

namespace App\Livewire\Patient;

use Livewire\Component;
use App\Models\Symptom;
use Illuminate\Support\Str;

class PatientSymptom extends Component
{

    public $openModalPatient = false;
    public $symptoms;
    public $user_symptoms_id;
    public $search = '';
    public $newName, $slug;
    public $user_symptoms;
   // public $arrayUser = [];

    public function mount($user_symptoms_id)
    {
        $this->user_symptoms_id = $user_symptoms_id;
    }

    public function addNew()
    {
        $name = $this->search;
        $name = mb_strtolower($name);
        $this->slug = Str::slug($name);
        $exist = Symptom::where('slug', $this->slug)->exists();
        if (!$exist) {
            Symptom::create([
                'name' => $name,
                'slug' => $this->slug,
            ]);
        } else {
            return session()->flash('fail', 'sintoma repetido');
        }
        $this->search = '';
        $this->render();
    }

    public function modify(Symptom $symptom)
    {
        //dd($symptom);
        array_push($this->user_symptoms_id, $symptom->id);
        //$this->dispatch( 'select', $this->user_symptoms_id);
    }

    public function del(Symptom $symptom)
    {
        $this->user_symptoms_id = array_filter(
            $this->user_symptoms_id,
            function ($key) use ($symptom) {
                return $symptom->id !== $key;
            });
           // $this->dispatch( 'select', $this->user_symptoms_id);
    }

    public function save()
    {
        $this->dispatch( 'select', $this->user_symptoms_id);
        $this->openModalPatient = false;
    }



    public function render()
    {
        $this->user_symptoms = Symptom::orderBy('name', 'asc')->whereIn('id', $this->user_symptoms_id)->pluck('name', 'id');
        $search = '%' . $this->search . '%';
        $this->symptoms = Symptom::orderBy('name', 'asc')->whereNotIn('id', $this->user_symptoms_id)->where('name', 'like', $search)
            ->take(10)->get();


        return view('livewire.patient.patient-symptom');
    }
}
