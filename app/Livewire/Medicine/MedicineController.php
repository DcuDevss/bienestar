<?php

namespace App\Livewire\Medicine;

use App\Models\Medicine;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;

class MedicineController extends Component
{
    use WithPagination;

    public $name, $slug, $create = true;
    public $medicine_id;

    protected $rules = ['name' => 'required'];

    public function add()
    {
        $data = $this->validate($this->rules);

        $slug = Str::slug($data['name']);
        $exists = Medicine::where('slug', $slug)->exists();
        if (!$exists) {
            Medicine::create(
                ['name' => mb_strtolower($data['name']), 'slug' => $slug]);
        }
        $this->reset('slug', 'name');
    }


    public function edit(Medicine $medicine){
        $this->name = $medicine->name;
        $this->medicine_id = $medicine->id;
        $this->create = false;
    }

    public function update(){
        $this->validate();
        $medicine = Medicine::find($this->medicine_id);
        $medicine->name = mb_strtolower($this->name);
        $medicine->slug = Str::slug($this->name);
        $medicine->save();
        $this->reset();
    }

    public function del(Medicine $medicine){
        $medicine->delete();
    }


    public function render()
    {
        $medicines = Medicine::orderBy('name', 'asc')->paginate(5);
        return view('livewire.medicine.medicine-controller', compact('medicines'));
    }
}
