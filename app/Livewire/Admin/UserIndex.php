<?php

namespace App\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserIndex extends Component
{
    use WithPagination;

    public function render()
    {
        $users= User::paginate();


        return view('livewire.admin.user-index',compact('users'));
    }
}
