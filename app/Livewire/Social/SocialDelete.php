<?php

namespace App\Livewire\Social;

use Livewire\Component;
use App\Models\Social;
use Illuminate\Support\Facades\DB;

class SocialDelete extends Component
{
    protected $listeners = ['reloadSocial'=>'reloadSocial'];

    public function reloadSocial(){
        $this->render();
    }

    public function delete(Social $social){
        $user = auth()->user();
        $toDelete = DB::table('social_user')->where('social_id', $social->id)
        ->where('user_id', $user->id)->delete();

    }

    public function render()
    {
        return view('livewire.social.social-delete');
    }
}
