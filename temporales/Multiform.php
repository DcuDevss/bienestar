<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Customer;

class Multiform extends Component
{
    public $name;
    public $email;
    public $color;

    public $step;

    public $custom;

    private $stepActions = [
        'submit1',
        'submit2',
        'submit3',
    ];

    public function mount()
    {
        $this->step = 0;
    }


    public function decreaseStep()
    {
        $this->step--;
    }

    public function render()
    {
        return view('livewire.multiform');
    }

    public function submit()
    {

        $action = $this->stepActions[$this->step];

        $this->$action();
    }

    public function submit1()
    {
        $this->validate([
            'name' => 'required|min:4',
        ]);

        if ($this->custom) {
            $this->custom= tap($this->custom)->update(['name' => $this->name]);
            session()->flash('message', 'Customer successfully updated.');

        }else {
            $this->custom = Customer::create(['name' => $this->name]);
            session()->flash('message', 'Customer successfully created.');

        }


        $this->step++;
    }

    public function submit2()
    {
        $this->validate([
            'email' => 'email|required',
        ]);

        $this->custom = tap($this->custom)->update(['email' => $this->email]);

        $this->step++;
    }
    public function submit3()
    {
        $this->validate([
            'color' => 'required',
        ]);

        $this->custom = tap($this->custom)->update(['color' => $this->color]);

        session()->flash('message', 'Wow! '. $this->custom->color .' is nice color '. $this->custom->name);

        $this->step++;

    }
}
